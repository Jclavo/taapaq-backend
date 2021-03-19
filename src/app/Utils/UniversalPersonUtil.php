<?php

namespace App\Utils;

use App\Models\UniversalPerson;
use App\Models\CompanyProject;
use App\Models\PersonType;
use App\Models\User;

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

    static function belongsToCompanyProject($person_id, $type_id, $created_by, $company_project_id){

        //Check by created_user
        $user = User::where('id',$created_by)
                      ->where('company_project_id',$company_project_id)
                      ->count();

        if ($user > 0) {
            return 1;
        }

        //Check by relation with company project table
        if ($type_id == PersonType::getForNatural()) {

            $belongs = CompanyProject::join('users','company_project.id','=','users.company_project_id')
                            ->join('universal_people','users.universal_person_id','=','universal_people.id')
                            ->where('universal_people.id', $person_id)
                            ->where('company_project.id', $company_project_id)
                            ->count();

        }else if ($type_id == PersonType::getForJuridical()) {
            
            $belongs = CompanyProject::join('companies','company_project.company_id','=','companies.id')
                            ->join('universal_people','companies.universal_person_id','=','universal_people.id')
                            ->where('universal_people.id', $person_id)
                            ->where('company_project.id', $company_project_id)
                            ->count();
        }else{
            return 0;
        }
      
        if ($belongs > 0) {
            return 1;
        }
        return 0;
    }


}