<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Utils\ProjectUtil;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $project = 'Taapaq';

        Project::updateOrCreate(['code' => 'A1'],['name' => 'Taapaq']); 
        // $newProject = ProjectUtil::createSuperProjectAndIts($project);
    }

}
