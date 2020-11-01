<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Module;
use App\Models\Resource;
use Spatie\Permission\Models\Permission;

class ResourceUtil
{
    static function createFromProjectCodeModule($projectCode, $ModuleName, $resourceName)
    {
        //get project
        $project = Project::where('code', $projectCode)->firstOrFail();

        $newModule = Module::updateOrCreate(['nickname' => 'Companies','project_id' => $project->id]);

        self::createCore($project->id, $newModule->id, $newModule->name, $resourceName);

    }

    static function createCore($project_id, $module_id, $moduleName, $resourceName)
    {
        $guardName = 'api';

        $newResource = Resource::updateOrCreate(['name' => $resourceName,'module_id' => $module_id ]);

        $moduleName = str_replace(" ","_",strtolower($moduleName));
        $resourceName = str_replace(" ","_",strtolower($newResource->name));

        $permissionNickname = $moduleName . '/' . $resourceName;
        $permissionName = $permissionNickname . '#' . $project_id;

        $newPermission = Permission::updateOrCreate(['name' => $permissionName, 'resource_id' => $newResource->id],
                                                    ['nickname' => $permissionNickname, 'guard_name' => $guardName]);
            
        return $newResource;
    }


    /**
     * VALUES SECTION
     */

    static function getResourceCommons(){
        return [
                'create',
                'update',
                'read',
                'delete',
                'pagination',
                'show',
        ]; 
    }

    static function getForProjectModule(){

        $forProject = [
                'assign-company',
                'remove-company',
            ];
            
        return array_merge(self::getResourceCommons(), $forProject);
    }

    static function getForRoleModule(){

        $forRole = [
                'give-permission',
                'revoke-permission',
            ];
            
        return array_merge(self::getResourceCommons(), $forRole);
    }

    static function getForUserModule(){

        $forRole = [
                'activated-status',
                'assign-role',
                'remove-role',
            ];
            
        return array_merge(self::getResourceCommons(), $forRole);
    }

    
}