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
        Project::updateOrCreate(['code' => env('PROJECT_TAAPAQ_CODE')],['name' => 'Taapaq']);
        
        ProjectUtil::assignCompanyFromCode(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                           env('PROJECT_TAAPAQ_CODE'));
    }

}
