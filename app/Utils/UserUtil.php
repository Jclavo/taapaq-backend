<?php

namespace App\Utils;

use App\Models\UniversalPerson;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use App\Models\RanqhanaUser;

use Illuminate\Support\Facades\Hash;

use App\Utils\ProjectUtil;
use App\Utils\UniversalPersonUtil;
use App\Utils\CompanyUtil;

// use App\Services\RanqhanaUserService;

class UserUtil
{
    static function getForIdentification($company_id,$project_id, $identification){

        $companyProjectID = ProjectUtil::getCompanyProjectID($company_id,$project_id);

        $universalPersonCompany = UniversalPersonUtil::getFromIdentification($identification);
        return User::where('universal_person_id', $universalPersonCompany->id)->
                     where('company_project_id', $companyProjectID)->firstOrFail();
    }

    static function getForIdentificationCode($companyIdentification,$projectCode,$userIdentification){

        $company = CompanyUtil::getFromIdentification($companyIdentification);
        $project = ProjectUtil::getFromCode($projectCode);

        return self::getForIdentification($company->id,$project->id, $userIdentification);

    }



    static function createFromCompanyProject($companyIdentification, $projectCode, $userIdentification, $activated = false){
        
        $company_project_id = ProjectUtil::getCompanyProjectIDFromCode($companyIdentification, $projectCode);

        //get company 
        $universalPerson = UniversalPersonUtil::getFromIdentification($userIdentification);

        return self::createCore($company_project_id,$universalPerson, $activated);
    }


    static function createCore($company_project_id, $universalPerson, $activated = false){
        
        $login = $universalPerson->identification . $company_project_id;

        $newUser = User::updateOrCreate(['login' => $login ],
                                        ['password' => Hash::make($login),
                                         'activated' => $activated,
                                         'company_project_id' => $company_project_id,
                                         'universal_person_id' =>  $universalPerson->id ]);

        // sync user in Ranqhana DB
        self::syncRanqhanaUser($newUser->id, $newUser->login, $newUser->company_project_id);
       
        return $newUser;
    }

    /**
     * sync user in Ranqhana DB
     */
    static function syncRanqhanaUser($external_user_id,$login,$company_project_id){
        $ranqhanaUser = RanqhanaUser::updateOrCreate([
            'external_user_id' => $external_user_id,
            'login' => $login,
            'company_project_id' => $company_project_id,
        ]);
    }

    
    static function assignRoleFromCompanyProject($companyIdentification,$projectCode,$roleName,$userIdentification){

        $role = RoleUtil::getFromCompanyProjectCode($companyIdentification, $projectCode,$roleName);

        $user = self::getForIdentificationCode($companyIdentification, $projectCode,$userIdentification);

        $user->assignRole($role);
    }

}