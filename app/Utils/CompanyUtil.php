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
}