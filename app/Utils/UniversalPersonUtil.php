<?php

namespace App\Utils;

use App\Models\UniversalPerson;

class UniversalPersonUtil
{
    static function getFromIdentification($identification){

        return UniversalPerson::where('identification', $identification)->firstOrFail();
    }
}