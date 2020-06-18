<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Module;
use App\Models\Resource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProjectUtil
{

    /***
     * Create Project and all its connections
     */
    static function createProjectAndIts(string $projectName){

        $resources = array(
            'Create',
            'Read',
            'Update',
            'Delete',
            'Show',
            'Pagination'
        );

        $resourcesRoles = $resources;
        $resourcesUsers = $resources;

        array_push($resourcesUsers,'activated status','assign role','remove role');
        array_push($resourcesRoles,'give permission','revoke permission');
        
        
        $modules = [
            (object) array('name' => 'Roles', 'url' => '/role-list', 'activated' => true,
                           'resources' => $resourcesRoles),
            
            (object) array('name' => 'Users', 'url' => '/user-list', 'activated' => true, 
                           'resources' => $resourcesUsers),
            
            (object) array('name' => 'Users Masters', 'url' => '/user-detail-list', 'activated' => true, 'resources' => $resources),
            
            (object) array('name' => 'Permissions', 'url' => '/permission-list', 'activated' => false, 'resources' => $resources),
        ];

        $roles = [
            'admin',
        ];
        
        
        //Create a project
        $newProject = factory(Project::class)->create(['name' => $projectName]);

        //Create Roles
        foreach ($roles as $role) {

            $adminRole = Role::create(['name' => $role . '/' . $newProject->id , 'project_id' => $newProject->id,
                                   'nickname' => $role]);

        }

        //Create modules for the project
        foreach ($modules as $module) {

            $newModule = $newProject->modules()->save(
                factory(Module::class)->make(['name' => $module->name,
                                        'url' => $module->url, 
                                        'visibled' =>  $module->activated])
            );

            foreach ($module->resources as $resource) {

                $newResource = $newModule->resources()->save(
                    factory(Resource::class)->make(['name' => $resource])
                );

                $permissionNickname = strtolower($newResource->module->name . '/' . str_replace(" ","-", $newResource->name));
                $permissionName = $permissionNickname . '#' . $newResource->module->project_id;

                $newPermission = Permission::create(['name' => $permissionName,
                                                    'resource_id' => $newResource->id,
                                                    'nickname' => $permissionNickname]);

                $adminRole->givePermissionTo($newPermission->id);

            }
        }

        return $newProject;
    }

}