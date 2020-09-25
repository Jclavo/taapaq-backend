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

    /**
     * Get the translation for the model
     */
    public function translations()
    {
        return $this->hasMany('App\Models\Translation', 'model_id')
                    ->orderBy('name');
    }
}
