<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    public function bomHeader()
    {
        return $this->hasMany(BomLineItem::class, 'project_id');
    }
}
