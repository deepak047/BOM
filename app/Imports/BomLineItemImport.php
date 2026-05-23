<?php

namespace App\Imports;

use App\Models\BomLineItem;
use App\Models\BomHeader;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BomLineItemImport implements ToCollection, WithHeadingRow
{
    protected $bomHeaderId;

    public function __construct($bomHeaderId)
    {
        $this->bomHeaderId = $bomHeaderId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalize column names (Rev‑1 vs Rev‑2)
            $itemCodeKeys  = ['item_code', 'part_number', 'item code'];
            $descKeys      = ['description', 'item_description', 'desc'];
            $qtyKeys       = ['qty', 'required_qty', 'quantity'];
            $uomKeys       = ['uom', 'unit', 'unit_of_measure'];
            $specKeys      = ['specification', 'spec', 'material_grade'];
            $allocToKeys   = ['allocated_to', 'department', 'role', 'allocated to'];

            $itemCode  = $this->firstNotEmpty($row, $itemCodeKeys);
            if (empty($itemCode)) continue; // skip invalid row

            $description = $this->firstNotEmpty($row, $descKeys, '');
            $qty        = (int) $this->firstNotEmpty($row, $qtyKeys, 0);
            $uom        = $this->firstNotEmpty($row, $uomKeys, 'EA');
            $spec       = $this->firstNotEmpty($row, $specKeys, '');
            $allocatedTo = $this->firstNotEmpty($row, $allocToKeys, '');

            BomLineItem::create([
                'bom_header_id' => $this->bomHeaderId,
                'item_code'     => $itemCode,
                'description'   => $description,
                'uom'           => $uom,
                'required_qty'  => $qty,
                'specification' => $spec,
                'allocated_to'  => $allocatedTo,
            ]);
        }
    }

    private function firstNotEmpty($row, array $keys, $default = null)
    {
        foreach ($keys as $key) {
            if ($row->has($key) && $row->get($key) !== null) {
                $val = trim($row->get($key));
                if ($val !== '') {
                    return $val;
                }
            }
        }
        return $default;
    }
}
