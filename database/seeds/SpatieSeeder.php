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
            $assign = false;
            if($role == 'admin'){
                $assign = true;
            }
            RoleUtil::createFromCompanyProjectCode(env('COMPANY_CLEIVOR_IDENTIFICATION'), env('PROJECT_TAAPAQ_CODE'),$role, $assign);
        }
    }

    /**
     * VALUES SECTION
    */

    static function getCommons(){
        return [
                'admin',
                'user',
        ]; 
    }
}
