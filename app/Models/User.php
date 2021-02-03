<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    //protected $with = ['person'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password', 'activated', 'company_project_id', 'universal_person_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the company_project that owns the user.
     */
    public function company_project()
    {
        return $this->belongsTo('App\Models\CompanyProject');
    }

    /**
     * Get the UniversalPerson that owns the user.
     */
    public function person()
    {
        return $this->belongsTo('App\Models\UniversalPerson', 'universal_person_id', 'id');
    }

    /**
     * Get the company that the user works.
     */
    public function company()
    {
        return $this->hasOneThrough(
            'App\Models\Company',
            'App\Models\CompanyProject', 
            'id', 
            'id', 
            'company_project_id',
            'company_id' 
        );
    }

    /**
     * Get the project that the user works.
     */
    public function project()
    {
        return $this->hasOneThrough(
            'App\Models\Project',
            'App\Models\CompanyProject', 
            'id', 
            'id', 
            'company_project_id',
            'project_id' 
        );
    }

    //Custom functions
    
    /**
     * Check is user is Super 
     */
    public function isSuper(){
        if (strpos($this->login,'45960630') !== false) {
            return true;
        }
        return false;
    }
}
