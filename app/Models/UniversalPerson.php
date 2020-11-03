<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversalPerson extends Model
{
    protected $table = 'universal_people';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identification', 'email', 'name', 'lastname', 'phone', 'address'
    ];

    /**
     * Get the users for the UniversalPerson
     */
    public function users()
    {
        return $this->hasMany('App\Models\User')
                    ->orderBy('login');
    }

    /**
     * Get the companies for the UniversalPerson
     */
    public function companies()
    {
        return $this->hasMany('App\Models\Company');
                    // ->orderBy('login');
    }
}
