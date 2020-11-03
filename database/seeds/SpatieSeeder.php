<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Utils\RoleUtil;

class SpatieSeeder extends Seeder
{

    public function run()
    { 
        foreach (self::getCommons() as $role){
            RoleUtil::createFromCompanyProjectCode(env('COMPANY_CLEIVOR_IDENTIFICATION'), env('PROJECT_TAAPAQ_CODE'),
                                                   $role->name, $role->assign);
        }
    }

    /**
     * VALUES SECTION
    */

    static function getCommons(){
        return [
            (object) array('name' => 'admin', 'assign' => true),
            (object) array('name' => 'user', 'assign' => false),
            (object) array('name' => 'client', 'assign' => false)
        ]; 
    }
}
