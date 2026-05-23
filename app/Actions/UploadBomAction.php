<?php

namespace App\Actions;

use App\Models\BomHeader;
use App\Models\ActivityLog;
use App\Jobs\CheckInventoryJob;
use App\Imports\BomLineItemImport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UploadBomAction
{
    /**
     * Execute the BOM upload, import, and processing pipeline.
     */
    public function __invoke(UploadedFile $file, int $projectId, ?int $userId): BomHeader
    {
        // 1. Handle File Storage
        $ext = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $ext;
        $path = $file->storeAs('bom-uploads', $fileName, 'local');

        // 2. Create the Database Header Record
        $bom = BomHeader::create([
            'project_id'    => $projectId,
            'bom_reference' => 'BOM-' . Str::random(8),
            'file_name'     => $file->getClientOriginalName(),
            'file_path'     => $path,
            'structure'     => [], 
        ]);

        ActivityLog::create([
        'action'     => 'bom_uploaded',
        'model_type' => get_class($bom),
        'model_id'   => $bom->id,
        'user_id'    => $userId ?? auth()->id(),
        'details'    => json_encode([
            'original_filename' => $file->getClientOriginalName(),
            'bom_reference'     => $bom->bom_reference,
            'project_id'        => $projectId,
            'storage_path'      => $path
        ])
    ]);

        // 3. Execute the Excel Import
        Excel::import(
            new BomLineItemImport($bom->id),
            Storage::disk('local')->path($path)
        );

        // 4. Kick off async inventory check
        CheckInventoryJob::dispatch($bom, $userId);
       
        return $bom;
    }
}