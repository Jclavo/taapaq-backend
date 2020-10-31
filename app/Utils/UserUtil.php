<?php

namespace App\Utils;

use App\Models\UniversalPerson;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserUtil
{

    static function createFromCompanyProject($companyIdentification, $projectCode, $userIdentification ){
        
        //get company 
        $universalPersonCompany = UniversalPerson::where('identification', $companyIdentification)->firstOrFail();
        $company = Company::where('universal_person_id', $universalPersonCompany->id)->firstOrFail();

        //get project
        $project = Project::where('code', $projectCode)->firstOrFail();

        //get company 
        $universalPersonUser = UniversalPerson::where('identification', $userIdentification)->firstOrFail();

        return self::createCore($company->id,$project->id,$universalPersonUser->id);
    }


    static function createCore($company_id, $project_id, $universal_person_id){
        
        //get company 
        $company = Company::findOrFail($company_id);

        //get project
        $project = Project::findOrFail($project_id);

        //get company 
        $universalPersonUser = UniversalPerson::findOrFail($universal_person_id);

        //Create relationship between Project and Company
        $project->companies()->syncWithoutDetaching($company);
        $projectCompany = $project->companies()->where('company_id', $company->id)->first();  

        $login = $universalPersonUser->identification . $projectCompany->pivot->id;

        $newUser = User::updateOrCreate(['login' => $login ],
                                        ['password' => Hash::make($login),
                                         'activated' => false,
                                         'company_project_id' => $projectCompany->pivot->id,
                                         'universal_person_id' =>  $universalPersonUser->id ]);

        return $newUser;
    }


}