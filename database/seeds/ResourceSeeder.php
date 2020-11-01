<?php

use Illuminate\Database\Seeder;

use App\Utils\ResourceUtil;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResourceUtil::createFromProjectCodeModule('A1','Companies','read');
    }


    /**
     * VALUES SECTION
    */

    static function getResourceCommons(){
        return [
                'create',
                'update',
                'read',
                'delete',
                'pagination',
                'show',
        ]; 
    }

    static function getForProjectModule(){

        $forProject = [
                'assign-company',
                'remove-company',
            ];
            
        return array_merge(self::getResourceCommons(), $forProject);
    }

    static function getForRoleModule(){

        $forRole = [
                'give-permission',
                'revoke-permission',
            ];
            
        return array_merge(self::getResourceCommons(), $forRole);
    }

    static function getForUserModule(){

        $forRole = [
                'activated-status',
                'assign-role',
                'remove-role',
            ];
            
        return array_merge(self::getResourceCommons(), $forRole);
    }


}
