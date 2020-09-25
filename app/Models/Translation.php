<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    
    /**
     * RELATIONSHIPS
     */

    /**
     * Get the model that owns the Translation
     */
    public function model()
    {
        return $this->belongsTo('App\Models\SystemModel');
    }
}
