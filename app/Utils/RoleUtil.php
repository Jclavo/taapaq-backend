<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Company;
use App\Models\UniversalPerson;
use App\Models\CustomSpatieRole as Role;
use Spatie\Permission\Models\Permission;

use  App\Utils\ProjectUtil;
use  App\Utils\CompanyUtil;

class RoleUtil
{
    static function getFromCompanyProjectCode($companyIdentification,$projectCode, $roleName){
        
        $company = CompanyUtil::getFromIdentification($companyIdentification);
        $project = ProjectUtil::getFromCode($projectCode);

        return self::getFromCompanyProject($company->id,$project->id, $roleName);
    }

    static function getFromCompanyProject($company_id,$project_id, $roleName){
        
        $companyProjectID = ProjectUtil::getCompanyProjectID($company_id,$project_id);

        return Role::where('nickname', $roleName)->
                     where('company_project_id', $companyProjectID)->firstOrFail();
    }

    static function createFromCompanyProjectCode($companyIdentification,$projectCode, $roleName, $assign = false)
    {
        //get project
        $project = ProjectUtil::getFromCode($projectCode);

        //get company 
        $company = CompanyUtil::getFromIdentification($companyIdentification);

        return self::createCore($company->id, $project->id, $roleName, $assign);
    }

    static function createCore($company_id, $project_id, $roleName, $assign = false)
    {
        $companyProjectID = ProjectUtil::getCompanyProjectID($company_id,$project_id);

        $nickname = strtoupper($roleName);
        $name = str_replace(" ","_",$roleName) . '/' . $project_id;

        $role = Role::updateOrCreate(['name' => $name , 'company_project_id' => $companyProjectID],
                                     ['nickname' => $nickname]);

        if($assign){
            self::assignAllPermisssionByProject($project_id,$role);
        }

        return $role; 
    }


    static function assignAllPermisssionByProject($project_id, $role){

        $permissions = Permission::select('permissions.*')
                    ->join('resources', 'permissions.resource_id', '=', 'resources.id')
                    ->join('modules', 'resources.module_id', '=', 'modules.id')
                    ->join('projects', 'modules.project_id', '=', 'projects.id')
                    ->where('projects.id', $project_id)
                    ->get();

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->id);
        }

    }



    

}