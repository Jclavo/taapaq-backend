<?php

namespace App\Models;

use App\Models\BaseModel;

class Country extends BaseModel
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
     * Get all translations.
     */
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translationable');
        // ->with('detail');
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
