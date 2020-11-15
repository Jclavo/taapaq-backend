<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversalPerson extends Model
{
    protected $table = 'universal_people';
    protected $with = 'type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identification', 'email', 'name', 'lastname', 'phone', 'address', 'country_code'
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

    /**
     * Get the UniversalPerson that owns the user.
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PersonType', 'type_id', 'code');
    }

    /**
     * Get the country that owns the person.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_code', 'code');
    }
}
