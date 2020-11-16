<?php

namespace App\Models;

use App\Models\BaseModel;

class Locale extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'language'
    ];

        //Relationships
    
    /**
     * Get all translations.
     */
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translationable');
    }

}
