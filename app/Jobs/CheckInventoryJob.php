<?php

namespace App\Jobs;

use App\Models\BomHeader;
use App\Models\BomLineItem;
use App\Models\Inventory;
use App\Models\PurchaseIntent;
use App\Models\MaterialAllocation;
use App\Models\ActivityLog;
use App\Notifications\PurchaseIntentCreated;
use App\Notifications\MaterialAllocationCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str; 

class CheckInventoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bom;
    protected $userId; 
    /**
     * Pass the BOM header and the performing user's ID
     */
    public function __construct(BomHeader $bom, ?int $userId = null)
    {
        $this->bom = $bom;
        $this->userId = $userId ?? auth()->id(); 
    }

    public function handle()
    {
        
        $lines = $this->bom->lineItems; 
        $intentBatchId = 'INTENT-' . Str::random(8);

        

        foreach ($lines as $line) {
            try {
                
                DB::transaction(function () use ($line, $intentBatchId) {

            
                    $inv = Inventory::where('item_code', $line->item_code)->lockForUpdate()->first();

                    

                    $availableQty = $inv ? $inv->available_qty : 0;
                    $available = max(0, $availableQty);
                    $required = $line->required_qty;

                    $status = 'out_of_stock';

                    if ($available >= $required) {
                        $status = 'in_stock';
                        $line->update(['status' => $status]);
                        $this->allocateMaterial($line, $inv, $required);
                    } elseif ($available > 0 && $available < $required) {
                        $status = 'partial_stock';
                        $line->update(['status' => $status]);
                        $this->allocateMaterial($line, $inv, $available);
                        $this->raisePurchaseIntent($line, $required, $available, $intentBatchId);
                    } else {
                        $status = 'out_of_stock';
                        $line->update(['status' => $status]);
                        $this->raisePurchaseIntent($line, $required, 0, $intentBatchId);
                    }

                   
                 
                    ActivityLog::create([
                        'action'     => 'inventory_checked',
                        'model_type' => get_class($line),
                        'model_id'   => $line->id,
                        'user_id'    => $this->userId,
                        'details'    => json_encode(['status' => $status])
                    ]);
                });

            } catch (\Exception $e) {
                
                    ActivityLog::create([
                        'action'     => 'inventory_check_failed',
                        'model_type' => get_class($line),
                        'model_id'   => $line->id,
                        'user_id'    => $this->userId,
                        'details'    => json_encode([
                                            'item_code' => $line->item_code,
                                            'error'     => $e->getMessage()
                                        ])
                    ]);
               
            }
        }
    }


    private function allocateMaterial($item, ?Inventory $inventory, $qty)
    {
        if (!$inventory) {
            return;
        }
        // Atomically decrement stock
        $inventory->decrement('available_qty', $qty);


        $allocation = MaterialAllocation::create([
            'bom_reference' => $this->bom->bom_reference,
            'bom_header_id' => $this->bom->id,
            'item_code'     => $item->item_code,
            'description'   => $item->description ?? '',
            'allocated_qty' => $qty,
            'allocated_to'  => $item->allocated_to ?? 'Production',
            'allocated_by'  => 'system:auto',//check
        ]);
        
        ActivityLog::create([
            'action'     => 'material_allocated',
            'model_type' => get_class($allocation),
            'model_id'   => $allocation->id,
            'user_id'    => $this->userId,
            'details'    => json_encode([
                'item_code'     => $item->item_code,
                'allocated_qty' => $qty,
                'warehouse_id'  => $inventory->id
            ])
        ]);

        Notification::route('mail', 'engineer@example.com')->notify(new MaterialAllocationCreated($allocation));



    }

    private function raisePurchaseIntent($item, $required, $available, $batchId)
    {

        $shortfall = max(0, $required - $available);

        $priority = 'medium';
        if (isset($this->bom->project) && isset($this->bom->project->priority)) {
            $priority = $this->bom->project->priority;
        }

        $intent = PurchaseIntent::create([
            'bom_header_id' => $this->bom->id,
            'bom_reference' => $this->bom->bom_reference,
            'item_code'     => $item->item_code,
            'description'   => $item->description ?? '',
            'specification' => $item->specification,
            'required_qty'  => $item->required_qty,
            'available_qty' => $available,
            'shortfall_qty' => $shortfall,
            'priority'      => $priority,
            'date_raised'   => now(),
            'status'        => 'pending',
                          
        ]);

        ActivityLog::create([
            'action'     => 'purchase_intent_raised',
            'model_type' => get_class($intent),
            'model_id'   => $intent->id,
            'user_id'    => $this->userId,
            'details'    => json_encode([
                'item_code'     => $item->item_code,
                'shortfall_qty' => $shortfall,
                'batch_id'      => $batchId,
                'priority'      => $priority
            ])
        ]);

         // Notify purchase dept (simplified)
       Notification::route('mail', 'purchase@example.com')->notify(new PurchaseIntentCreated($intent));
        
       
    }
}