<?php

namespace App\Utils;

use App\Models\Project;
use Spatie\Permission\Models\Role;

class RoleUtil
{
    static function createFromProjectCode($projectCode, $roleName)
    {
        //get project
        $project = Project::where('code', $projectCode)->firstOrFail();

        return self::createCore($project->id, $roleName);
    }

    static function createCore($project_id, $roleName)
    {
        
        $nickname = strtoupper($roleName);
        $name = str_replace(" ","_",$roleName) . '/' . $project_id;

        $role = Role::updateOrCreate(['name' => $name , 'project_id' => $project_id],
                                     ['nickname' => $nickname]);

        return $role;
        
    }

    

}