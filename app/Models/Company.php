<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id'
    ];

    /**
     * The projects that belong to the company.
     */
    public function projects()
    {
        return $this->belongsToMany('App\Models\Project')
                    ->using('App\Models\CompanyProject')
                    ->withTimestamps()
                    ->withPivot('id')
                    ->orderBy('name');
    }

    /**
     * Get all of the users for the company.
     */
    public function users()
    {
        return $this->hasManyThrough('App\Models\User','App\Models\CompanyProject',
                                      'company_id', 'company_project_id')
                                     ->orderBy('login');  
                                      
    }

    /**
     * Get the country that owns the company.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
