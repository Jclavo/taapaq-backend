<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'timezone', 'currency'
    ];


    //Relationships

    /**
     * Get the companies for the country.
     */
    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }
    
}
