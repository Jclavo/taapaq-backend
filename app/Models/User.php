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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password'
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
     * Get the UserDetail that owns the user.
     */
    public function user_detail()
    {
        return $this->belongsTo('App\Models\UserDetail');
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
