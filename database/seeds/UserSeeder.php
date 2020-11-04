<?php

use Illuminate\Database\Seeder;
use App\Models\User;

use App\Utils\UserUtil;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
         /**from TAAPAQ */
        UserUtil::createFromCompanyProject(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                           env('PROJECT_TAAPAQ_CODE'),
                                           env('USER_COCO_IDENTIFICATION'), true); 
        /**from RANQHANA */
        UserUtil::createFromCompanyProject(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                           env('PROJECT_RANQHANA_CODE'),
                                           env('USER_COCO_IDENTIFICATION'), true); 

        foreach (SpatieSeeder::getCommons() as $role){
            /**from TAAPAQ */
            UserUtil::assignRoleFromCompanyProject(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                                   env('PROJECT_TAAPAQ_CODE'),$role->name,
                                                   env('USER_COCO_IDENTIFICATION'));
                                            
            /**from RANQHANA */
            UserUtil::assignRoleFromCompanyProject(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                                   env('PROJECT_RANQHANA_CODE'),$role->name,
                                                   env('USER_COCO_IDENTIFICATION'));
        }

    }
}
