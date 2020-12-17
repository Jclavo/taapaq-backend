<?php

namespace App\Models;

use App\Models\BaseModel;

class Module extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'url', 'visibled', 'project_id', 'parent_id', 'labeled', 'icon', 'order'
    ];

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = str_replace(" ","_",strtolower($value));
    // }

    /**
     * Get all translations.
     */
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translationable');
    }

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
        return $this->hasMany('App\Models\Module','parent_id')
                    ->orderBy('order')   
                    ->with(['children','resources']);
    }
    public function parent() {
        return $this->belongsTo('App\Models\Module','parent_id');
    }
}
