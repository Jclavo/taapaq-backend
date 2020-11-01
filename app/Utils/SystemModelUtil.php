<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\SystemModel;

class SystemModelUtil
{
    static function createFromProjectCode($projectCode, $systemModelName)
    {
        //get project
        $project = Project::where('code', $projectCode)->firstOrFail();

        return self::createCore($project->id, $systemModelName);
    }

    static function createCore($project_id, $systemModelName)
    {
        $systemModel = SystemModel::updateOrCreate(['name' => $systemModelName, 'project_id' => $project_id]);

        return $systemModel;
    }
}