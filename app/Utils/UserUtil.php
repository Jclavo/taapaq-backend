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

    static function createFromCompanyProject($companyIdentification, $projectCode, $userIdentification, $activated = false){
        
    //     //get company 
    //    $company = CompanyUtil::getFromIdentification($companyIdentification);

    //     //get project
    //     $project = ProjectUtil::getFromCode($projectCode); = 

    $company_project_id = ProjectUtil::getCompanyProjectIDFromCode($companyIdentification, $projectCode);

        //get company 
        $universalPerson = UniversalPersonUtil::getFromIdentification($userIdentification);

        return self::createCore($company_project_id,$universalPerson, $activated);
    }


    // static function createCore($company_id, $project_id, $universal_person_id, $activated = false){
        
    //     //get company 
    //     $universalPerson = UniversalPerson::findOrFail($universal_person_id);

    //     $companyProjectID = ProjectUtil::getCompanyProjectID($company_id,$project_id);

    //     $login = $universalPerson->identification . $companyProjectID;

    //     $newUser = User::updateOrCreate(['login' => $login ],
    //                                     ['password' => Hash::make($login),
    //                                      'activated' => $activated,
    //                                      'company_project_id' => $companyProjectID,
    //                                      'universal_person_id' =>  $universalPerson->id ]);

    //     return $newUser;
    // }
    static function createCore($company_project_id, $universalPerson, $activated = false){
        
        $login = $universalPerson->identification . $company_project_id;

        $newUser = User::updateOrCreate(['login' => $login ],
                                        ['password' => Hash::make($login),
                                         'activated' => $activated,
                                         'company_project_id' => $company_project_id,
                                         'universal_person_id' =>  $universalPerson->id ]);

        return $newUser;
    }


    static function assignRoleFromCompanyProject($companyIdentification,$projectCode,$roleName,$userIdentification){

        $role = RoleUtil::getFromCompanyProjectCode($companyIdentification, $projectCode,$roleName);

        $user = self::getForIdentification($userIdentification);

        $user->assignRole($role);
    }




}