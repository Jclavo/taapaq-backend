<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Module;
use App\Models\Resource;
use App\Models\UniversalPerson;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\CustomSpatieRole as Role;

class ProjectUtil
{
    static function getFromCode($code){
        return Project::where('code', $code)->firstOrFail();
    }

    static function getCompanyProjectIDFromCode($companyIdentification, $projectCode){

        $company = CompanyUtil::getFromIdentification($companyIdentification);
        $project = ProjectUtil::getFromCode($projectCode);
        
        return self::getCompanyProjectID($company->id,$project->id);
    }

    static function getCompanyProjectID($company_id, $project_id){

        //get company 
        $company = Company::findOrFail($company_id);

        //get project
        $project = Project::findOrFail($project_id);

        //get relationship between Project and Company
        $companyProject = $project->companies()->where('company_id', $company->id)->firstOrFail();
       
        return $companyProject->pivot->id;
    }

    static function createCompanyProjectIDFromCode($companyIdentification, $projectCode){

        $company = CompanyUtil::getFromIdentification($companyIdentification);
        $project = ProjectUtil::getFromCode($projectCode);
        
        return self::getCompanyProjectID($company->id,$project->id);
    }

    static function createCompanyProjectID($company_id, $project_id){

        //get company 
        $company = Company::findOrFail($company_id);

        //get project
        $project = Project::findOrFail($project_id);

        //Create relationship between Project and Company
        $project->companies()->syncWithoutDetaching($company);
        $companyProject = $project->companies()->where('company_id', $company->id)->firstOrFail();
       
        return $companyProject->pivot->id;
    }

    static function assignCompanyFromCode($companyIdentification, $projectCode){

        $company = CompanyUtil::getFromIdentification($companyIdentification);
        $project = ProjectUtil::getFromCode($projectCode);
        
        return self::assignCompany($company->id,$project->id);
    }

    static function assignCompany($company_id,$project_id){

        $company = Company::findOrFail($company_id);
        $project = Project::findOrFail($project_id);
        
        $project->companies()->syncWithoutDetaching($company); // add many to many relationship

        return $project;
    }












    // /***
    //  * Create Project and all its connections
    //  */
    // static function createProjectAndIts(string $projectName){

    //     DB::transaction(function () use($projectName) {

    //         $resources = array(
    //             'Create',
    //             'Read',
    //             'Update',
    //             'Delete',
    //             'Show',
    //             'Pagination'
    //         );

    //         $resourcesRoles = $resources;
    //         $resourcesUsers = $resources;

    //         array_push($resourcesUsers,'activated status','assign role','remove role');
    //         array_push($resourcesRoles,'give permission','revoke permission');
            
            
    //         $modules = [
    //             (object) array('name' => 'Roles', 'url' => '/role-list', 'activated' => true,
    //                         'resources' => $resourcesRoles),
                
    //             (object) array('name' => 'Users', 'url' => '/user-list', 'activated' => true, 
    //                         'resources' => $resourcesUsers),
                
    //             (object) array('name' => 'Users Masters', 'url' => '/user-detail-list', 'activated' => true, 'resources' => $resources),
                
    //             (object) array('name' => 'Permissions', 'url' => '/permission-list', 'activated' => false, 'resources' => $resources),
    //         ];

    //         $roles = [
    //             'admin',
    //         ];
            
            
    //         //Create a project
    //         $newProject = factory(Project::class)->create(['name' => $projectName]);

    //         //Create Roles
    //         foreach ($roles as $role) {

    //             $adminRole = Role::create(['name' => $role . '/' . $newProject->id , 'project_id' => $newProject->id,
    //                                 'nickname' => $role]);

    //         }

    //         //Create modules for the project
    //         foreach ($modules as $module) {

    //             $newModule = $newProject->modules()->save(
    //                 factory(Module::class)->make(['name' => $module->name,
    //                                         'url' => $module->url, 
    //                                         'visibled' =>  $module->activated])
    //             );

    //             foreach ($module->resources as $resource) {

    //                 $newResource = $newModule->resources()->save(
    //                     factory(Resource::class)->make(['name' => $resource])
    //                 );

    //                 $permissionNickname = strtolower($newResource->module->name . '/' . str_replace(" ","-", $newResource->name));
    //                 $permissionName = $permissionNickname . '#' . $newResource->module->project_id;

    //                 $newPermission = Permission::create(['name' => $permissionName,
    //                                                     'resource_id' => $newResource->id,
    //                                                     'nickname' => $permissionNickname]);

    //                 $adminRole->givePermissionTo($newPermission->id);

    //             }
    //         }

    //         return $newProject;
    //     });
    // }


    // /***
    //  * Create Project and all its connections
    //  */
    // static function createSuperProjectAndIts(string $projectName){

    //     DB::transaction(function () use($projectName) {

    //         $resources = array(
    //             'Create',
    //             'Read',
    //             'Update',
    //             'Delete',
    //             'Show',
    //             // 'Pagination'
    //         );

    //         $resourcesRoles = $resources;
    //         $resourcesUsers = $resources;
    //         $resourcesProjects = $resources;

    //         array_push($resourcesUsers,'activated status','assign role','remove role');
    //         array_push($resourcesRoles,'give permission','revoke permission');
    //         array_push($resourcesProjects,'assign company','remove company');
            
            
    //         $modules = [

    //             (object) array('name' => 'Companies', 'url' => '/company-list', 'activated' => true,
    //                         'resources' => $resources),

    //             (object) array('name' => 'Projects', 'url' => '/project-list', 'activated' => true,
    //                         'resources' => $resourcesProjects),
                
    //             (object) array('name' => 'Modules', 'url' => '/module-list', 'activated' => true,
    //                             'resources' => $resources),

    //             (object) array('name' => 'Resources', 'url' => '/resource-list', 'activated' => false,
    //                             'resources' => $resources),

    //             (object) array('name' => 'Roles', 'url' => '/role-list', 'activated' => true,
    //                         'resources' => $resourcesRoles),
                
    //             (object) array('name' => 'Users', 'url' => '/user-list', 'activated' => true, 
    //                         'resources' => $resourcesUsers),
                
    //             (object) array('name' => 'Users Masters', 'url' => '/user-detail-list', 'activated' => true,
    //                         'resources' => $resources),
                
    //             (object) array('name' => 'Permissions', 'url' => '/permission-list', 'activated' => false,
    //                         'resources' => $resources),
    //         ];

    //         $roles = [
    //             'admin',
    //         ];

    //         $company = 'Cleivor SAC';
    //         $guard = 'api';


            
            
    //         //Create a project
    //         $newProject = factory(Project::class)->create(['name' => $projectName]);

    //         //Create a company
    //         $newCompany = factory(Company::class)->create(['name' => $company]);

    //         //Create relationship between Project and Company
    //         $newProject->companies()->syncWithoutDetaching($newCompany);

    //         $project_company = $newProject->companies()->where('company_id', $newCompany->id)->first();  

    //         //Create Roles
    //         foreach ($roles as $role) {
    //             $adminRole = Role::create(['name' => $role . '/' . $newProject->id, 'project_id' => $newProject->id, 'nickname' => $role]);
    //         }


    //         $newUserMaster = factory(UniversalPerson::class)->create(['identification' => '45960630','email' => 'jclavo@example.com',
    //                                             'name' => 'Jose', 'lastname' => 'cleivor']);

                                            

    //         $newUser = factory(User::class)->create([
    //                                             'login' => $newUserMaster->identification . $project_company->pivot->id,
    //                                             'company_project_id' => $project_company->pivot->id,
    //                                             'universal_person_id' =>  $newUserMaster->id,                     
    //         ]);

    //         //Assign Role to user
    //         $newUser->assignRole($adminRole->id);

    //         //Set guard
    //         $adminRole->guard_name = $guard;
    //         $adminRole->save();

    //         //Create modules for the project
    //         foreach ($modules as $module) {

    //             $newModule = $newProject->modules()->save(
    //                 factory(Module::class)->make(['name' => $module->name,
    //                                         'url' => $module->url, 
    //                                         'visibled' =>  $module->activated])
    //             );

    //             foreach ($module->resources as $resource) {

    //                 $newResource = $newModule->resources()->save(
    //                     factory(Resource::class)->make(['name' => $resource])
    //                 );

    //                 $permissionNickname = strtolower($newResource->module->name . '/' . str_replace(" ","-", $newResource->name));
    //                 $permissionName = $permissionNickname . '#' . $newResource->module->project_id;

    //                 $newPermission = Permission::create(['name' => $permissionName, 'guard_name' => $guard,
    //                                                      'resource_id' => $newResource->id, 'nickname' => $permissionNickname]);

    //                 $adminRole->givePermissionTo($newPermission->id);

    //             }
    //         }

    //         return $newProject;
    //     });
    // }

}