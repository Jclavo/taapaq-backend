<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemModel extends Model
{
    
    /**
     * RELATIONSHIPS
     */

    /**
     * Get the project that owns the system_model
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
