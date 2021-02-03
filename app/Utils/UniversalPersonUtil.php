<?php

namespace App\Utils;

use App\Models\UniversalPerson;
use App\Models\CompanyProject;

class UniversalPersonUtil
{
    static function getFromIdentification($identification){

        return UniversalPerson::where('identification', $identification)->firstOrFail();
    }

    static function getCompanyProject($universal_person_id){

        return CompanyProject::join('companies','company_project.company_id','=','companies.id')
                    ->where('companies.universal_person_id', $universal_person_id)
                    ->get();
    }

}