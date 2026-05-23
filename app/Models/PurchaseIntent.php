<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseIntent extends Model
{
    //

    protected $fillable = [
    'bom_header_id',
    'bom_reference',
    'item_code',
    'description',
    'specification',
    'required_qty',
    'available_qty',
    'shortfall_qty',
    'priority',
    'date_raised',
    'status',
    ];
}
