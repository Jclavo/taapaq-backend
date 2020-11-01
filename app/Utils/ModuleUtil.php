<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Module;

class ModuleUtil
{
    static function createMassiveFromProjectCode($projectCode, $modules)
    {
        //get project
        $project = Project::where('code', $projectCode)->firstOrFail();

        self::createMassiveCore($project->id,$modules);
        
    }

    static function createMassiveCore($project_id, $modules){
        self::loopModules($project_id, $modules);
    }

    static function loopModules($project_id, $modules, $parent_id = null){

        foreach ($modules as $module) {

            $newModule = self::createCore($project_id,$module,$parent_id);

            if($module->children){
                self::loopModules($project_id, $module->children, $newModule->id);
            }
        }   

    }

    static function createCore($project_id, $module, $parent_id = null){

        $module->visibled = $module->visibled ?? true;
        $module->labeled = $module->labeled ?? false;

        $newModule = Module::updateOrCreate(['name' => $module->name,'project_id' => $project_id ],
                                ['url' => $module->url, 'visibled' => $module->visibled, 
                                 'parent_id' => $parent_id, 'labeled' => $module->labeled,
                                 'icon' => $module->icon ]);
                                
        return $newModule;
    }
}