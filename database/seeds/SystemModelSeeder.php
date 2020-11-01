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
        // $newProject = Project::updateOrCreate(['code' => 'A1']);
        // SystemModel::updateOrCreate(['name' => 'SYSTEM', 'project_id' => $newProject->id]);
        foreach (self::getForTaapaq() as $module){
            SystemModelUtil::createFromProjectCode('A1',$module);
        }
        
    }

    /**
     * VALUES SECTION
    */

    static function getForTaapaq(){
        return [
                'system',
                // '',
        ]; 
    }
}
