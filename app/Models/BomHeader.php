<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BomHeader extends Model
{
    protected $fillable = [
    'project_id',
    'bom_reference',
    'file_name',
    'file_path',
    'structure',
    ];

    protected $casts = [
        'structure' => 'array', 
    ];

    public function lineItems()
    {
        return $this->hasMany(BomLineItem::class, 'bom_header_id');
    }


     public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
