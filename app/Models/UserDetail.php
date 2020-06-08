<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identification', 'email', 'name', 'lastname', 'phone', 'address'
    ];

    /**
     * Get the user for the userDetail
     */
    public function modules()
    {
        return $this->hasMany('App\Models\User');
    }
}
