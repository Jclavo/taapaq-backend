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
        UserUtil::createFromCompanyProject(env('COMPANY_CLEIVOR_IDENTIFICATION'),env('PROJECT_TAAPAQ_CODE'),
                                           env('USER_COCO_IDENTIFICATION'), true); 
        
        foreach (SpatieSeeder::getCommons() as $role){
            UserUtil::assignRoleFromCompanyProject(env('COMPANY_CLEIVOR_IDENTIFICATION'),env('PROJECT_TAAPAQ_CODE'),$role, env('USER_COCO_IDENTIFICATION')); 
        }
        
        
    }
}
