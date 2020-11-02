<?php

namespace App\Utils;

use App\Models\Project;
use App\Models\Module;

use  App\Utils\ResourceUtil;
use  App\Utils\ProjectUtil;

class ModuleUtil
{
    static function getFromProjectCode($projectCode){
        
        //get project
        $project = ProjectUtil::getFromCode($projectCode);

        return self::getFromProject($project->id);
    }

    static function getFromProject($project_id){
        return Module::where('name',$module->name)->
                       where('project_id',$project_id)->firstOrFail();
    }


    static function createMassiveFromProjectCode($projectCode, $modules)
    {
        //get project
        $project = ProjectUtil::getFromCode($projectCode);

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
        $module->nickname = $module->name;
        $module->name = str_replace(" ","_",strtolower($module->name));

        $newModule = Module::updateOrCreate(['name' => $module->name,'project_id' => $project_id ],
                                ['nickname' => $module->nickname, 'url' => $module->url,
                                 'visibled' => $module->visibled, 'parent_id' => $parent_id,
                                 'labeled' => $module->labeled, 'icon' => $module->icon ]);

        //Check if the module has resources
        if($module->resources){

            foreach ($module->resources as $resource){
                ResourceUtil::createCore($project_id, $newModule->id, $newModule->name,$resource);
            }

        }
                                
        return $newModule;
    }
}