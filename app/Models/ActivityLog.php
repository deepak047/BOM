<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
    'action',
    'model_type',
    'model_id',
    'user_id',
    'details',
];

protected $casts = [
        'details' => 'array', 
    ];

}
