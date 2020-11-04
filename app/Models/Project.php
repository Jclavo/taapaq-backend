<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * Relationships
     */

    /**
     * Get the modules for the project
     */
    public function modules()
    {
        return $this->hasMany('App\Models\Module')
                    ->orderBy('name');
    }

    /**
     * The companies that belong to the project.
     */
    public function companies()
    {
        return $this->belongsToMany('App\Models\Company')
                    ->using('App\Models\CompanyProject')
                    ->withTimestamps()
                    ->withPivot('id');
    }

    /**
     * Get the roles for the project
     */
    public function roles()
    {
        return $this->hasMany('App\Models\CustomSpatieRole')
                    ->orderBy('name');
    }


    /**
     * Get the models for the project
     */
    public function system_models()
    {
        return $this->hasMany('App\Models\SystemModel')
                    ->orderBy('name');
    }
}
