<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialAllocation extends Model
{
    protected $fillable = [
    'bom_reference',
    'item_code',
    'description',
    'allocated_qty',
    'allocated_to',
    'allocated_by',
    'bom_header_id',
];
}
