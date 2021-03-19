<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\SystemModel;

use App\Utils\SystemModelUtil;

class SystemModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::getForTaapaq() as $module){
            SystemModelUtil::createFromProjectCode(env('PROJECT_TAAPAQ_CODE'),$module);
        }
        
    }

    /**
     * VALUES SECTION
    */

    static function getForTaapaq(){
        return [
                'system',
                'company',
                'country', //without permissions
                'image', //without permissions
                'locale', //without permissions
                'module',
                'permission',
                'project',
                'resource-common', //without permissions
                'resource',
                'role',
                'system-model',
                'translation', //without permissions
                'translation-detail', //without permissions
                'universal-person',
                'person-type',
                'user',  
        ]; 
    }
}
