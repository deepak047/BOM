<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
    'item_code',
    'description',
    'uom',
    'specification',
    'available_qty',
];

}
