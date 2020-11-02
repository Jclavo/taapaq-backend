<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\SystemModel;

use  App\Utils\ProjectUtil;

class SystemModelUtil
{
    static function createFromProjectCode($projectCode, $systemModelName)
    {
        //get project
        $project = ProjectUtil::getFromCode($projectCode);

        return self::createCore($project->id, $systemModelName);
    }

    static function createCore($project_id, $systemModelName)
    {
        $systemModel = SystemModel::updateOrCreate(['name' => $systemModelName, 'project_id' => $project_id]);

        return $systemModel;
    }
}