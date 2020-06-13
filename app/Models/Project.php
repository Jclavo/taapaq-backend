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
                    ->withPivot('id')
                    ->orderBy('name');
    }

    /**
     * Get the roles for the project
     */
    public function roles()
    {
        return $this->hasMany('Spatie\Permission\Models\Role')
                    ->orderBy('name');
    }
}
