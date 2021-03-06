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
        /** from TAAPAQ */
        Project::updateOrCreate(['code' => env('PROJECT_TAAPAQ_CODE')],['name' => 'Taapaq']);
        
        // ProjectUtil::assignCompanyFromCode(env('COMPANY_CLEIVOR_IDENTIFICATION'),
        //                                    env('PROJECT_TAAPAQ_CODE'));

        /** from RANQHANA */
        Project::updateOrCreate(['code' => env('PROJECT_RANQHANA_CODE')],['name' => 'Ranqhana']);
        
        // ProjectUtil::assignCompanyFromCode(env('COMPANY_CLEIVOR_IDENTIFICATION'),
        //                                    env('PROJECT_RANQHANA_CODE'));
    }

}
