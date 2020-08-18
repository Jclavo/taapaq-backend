<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'project_id', 'visibled', 'parent_id', 'labeled'
    ];

    /**
     * Get the project that owns the module
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    /**
     * Get the resources for the module
     */
    public function resources()
    {
        return $this->hasMany('App\Models\Resource')
                    ->orderBy('name');
    }
}
