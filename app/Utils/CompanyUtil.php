<?php

namespace App\Utils;

use App\Models\Company;
use App\Utils\UniversalPersonUtil;

class CompanyUtil
{
    static function getFromIdentification($identification){

        $universalPersonCompany = UniversalPersonUtil::getFromIdentification($identification);
        
        return Company::where('universal_person_id', $universalPersonCompany->id)->firstOrFail();

    }

    static function createFromIdentification($identification){
        $universalPerson = UniversalPersonUtil::getFromIdentification($identification);
        return self::createCore($universalPerson->id);
    }

    static function createCore($universal_person_id){

        return Company::updateOrCreate(['universal_person_id' => $universal_person_id]);
    }
}