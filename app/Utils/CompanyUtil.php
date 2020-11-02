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

    static function createFromIdentification($identification, $countryCode){
        $universalPerson = UniversalPersonUtil::getFromIdentification($identification);
        return self::createCore($universalPerson->id,$countryCode);
    }

    static function createCore($universal_person_id, $countryCode){

        return Company::updateOrCreate(['universal_person_id' => $universal_person_id, 'country_code' => $countryCode]);
    }
}