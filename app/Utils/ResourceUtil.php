<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Module;
use App\Models\Resource;
use Spatie\Permission\Models\Permission;

use  App\Utils\ProjectUtil;

class ResourceUtil
{
    // static function createFromProjectCodeModule($projectCode, $ModuleName, $resourceName)
    // {
    //     //get project
    //     $project = ProjectUtil::getFromCode($projectCode);

    //     $newModule = Module::updateOrCreate(['nickname' => 'Companies','project_id' => $project->id]);

    //     self::createCore($project->id, $newModule->id, $newModule->name, $resourceName);

    // }

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

}