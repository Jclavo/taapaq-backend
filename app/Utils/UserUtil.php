<?php

namespace App\Utils;

use App\Models\UniversalPerson;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

use App\Utils\ProjectUtil;
use App\Utils\UniversalPersonUtil;
use App\Utils\CompanyUtil;

class UserUtil
{
    static function getForIdentification($identification){
        $universalPersonCompany = UniversalPersonUtil::getFromIdentification($identification);
        return User::where('universal_person_id', $universalPersonCompany->id)->firstOrFail();
    }

    static function createFromCompanyProject($companyIdentification, $projectCode, $userIdentification ){
        
        //get company 
       $company = CompanyUtil::getFromIdentification($companyIdentification);

        //get project
        $project = ProjectUtil::getFromCode($projectCode);

        //get company 
        $universalPersonUser = UniversalPersonUtil::getFromIdentification($userIdentification);

        return self::createCore($company->id,$project->id,$universalPersonUser->id);
    }


    static function createCore($company_id, $project_id, $universal_person_id){
        
        //get company 
        $universalPersonUser = UniversalPerson::findOrFail($universal_person_id);

        $companyProjectID = ProjectUtil::getCompanyProjectID($company_id,$project_id);

        $login = $universalPersonUser->identification . $companyProjectID;

        $newUser = User::updateOrCreate(['login' => $login ],
                                        ['password' => Hash::make($login),
                                         'activated' => false,
                                         'company_project_id' => $companyProjectID,
                                         'universal_person_id' =>  $universalPersonUser->id ]);

        return $newUser;
    }


    static function assignRoleFromCompanyProject($companyIdentification,$projectCode,$roleName,$userIdentification){

        $role = RoleUtil::getFromCompanyProjectCode($companyIdentification, $projectCode,$roleName);

        $user = self::getForIdentification($userIdentification);

        $user->assignRole($role);
    }




}