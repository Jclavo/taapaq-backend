<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

use App\Utils\RoleUtil;

class SpatieSeeder extends Seeder
{

    public function run()
    { 
        foreach (self::getCommons() as $role){

            /**from TAAPAQ */
            RoleUtil::createFromCompanyProjectCode(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                                   env('PROJECT_TAAPAQ_CODE'),
                                                   $role->name, $role->assign);

            /**from RANQHANA */
            RoleUtil::createFromCompanyProjectCode(env('COMPANY_CLEIVOR_IDENTIFICATION'),
                                                   env('PROJECT_RANQHANA_CODE'),
                                                   $role->name, $role->assign);
        }
    }

    /**
     * VALUES SECTION
    */

    static function getCommons(){
        return [
            (object) array('name' => 'ADMIN', 'assign' => true),
            (object) array('name' => 'USER', 'assign' => false),
            (object) array('name' => 'CLIENT', 'assign' => false)
        ]; 
    }
}
