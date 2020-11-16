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
        'code', 'name', 'timezone', 'currency', 'locale', 'tax'
    ];


    //Relationships
    
    /**
     * Get all of the PaymentMethod translations.
     */
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translationable')->with('details');
        // return $this->morphMany('App\Models\Translation', 'translationable', null,null,'code');
    }

    /**
     * Get the companies for the country.
     */
    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }
   
}
