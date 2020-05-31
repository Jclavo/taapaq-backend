<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the modules for the project
     */
    public function modules()
    {
        return $this->hasMany('App\Models\Module');
    }

    /**
     * The companies that belong to the project.
     */
    public function companies()
    {
        return $this->belongsToMany('App\Models\Company');
    }
}
