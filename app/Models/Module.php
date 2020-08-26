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
        'name', 'url', 'project_id', 'visibled', 'parent_id', 'labeled', 'icon'
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

    /**
     * Local relationships
     */

    public function children() {
        return $this->hasMany('App\Models\Module','parent_id')->with(['children','resources']);
    }
    public function parent() {
        return $this->belongsTo('App\Models\Module','parent_id');
    }
}
