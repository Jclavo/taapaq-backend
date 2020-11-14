<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
    protected $fillable = [
        'code', 'name'
    ];

    /**Getters */
    static function getForNatural(){
        return 1;
    }

    static function getForJuridical(){
        return 2;
    }
}
