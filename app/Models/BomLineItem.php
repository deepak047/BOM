<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomLineItem extends Model
{
    protected $fillable = [
    'bom_header_id',
    'item_code',
    'description',
    'uom',
    'required_qty',
    'specification',
    'allocated_to',
    'status',
];

public function bomHeader(): BelongsTo
    {
        return $this->belongsTo(BomHeader::class, 'bom_header_id');
    }

}
