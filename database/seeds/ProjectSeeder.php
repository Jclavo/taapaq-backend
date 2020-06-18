<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Company;
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
        $project = 'Taapaq';
        $newProject = ProjectUtil::createSuperProjectAndIts($project);

        $projects = [
            'Store',
            'Map',
            'Corso'
        ];

        foreach ($projects as $project) {
            ProjectUtil::createProjectAndIts($project);
        }

    }

}
