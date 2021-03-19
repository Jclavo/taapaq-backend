<?php

namespace App\Models;

use App\Models\BaseModel;

class PersonType extends BaseModel
{
    protected $fillable = [
        'code', 'name'
    ];

        //Relationships
    
    /**
     * Get all translations.
     */
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translationable', null,null,'code');
    }

    /**Getters */
    static function getForNatural(){
        return 1;
    }

    static function getForJuridical(){
        return 2;
    }
}
