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

    }


    /**
     * VALUES SECTION
    */

    static function getResourceCommonsForListPage(){
        return [
                'delete',
                'pagination',
                'read',
                // 'show',
        ]; 
    }

    static function getResourceCommonsForSimplePage(){
        return [
            'create',
            'update'
        ];
    }

    static function getResourceCommons(){

        $resources = [];

        $resources = array_merge($resources,self::getResourceCommonsForListPage());

        $resources = array_merge($resources,self::getResourceCommonsForSimplePage());

        return $resources;
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
