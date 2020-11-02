<?php

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Utils\ModuleUtil;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModuleUtil::createMassiveFromProjectCode(env('PROJECT_TAAPAQ_CODE'),self::getForTaapaq());
    }


    /**
     * VALUES SECTION
     */

    static function getForTaapaq(){

        // $labelTapaaq = new Module();
        // $labelTapaaq->name = 'Taapaq';
        // $labelTapaaq->url = null;
        // $labelTapaaq->visibled = true;
        // // $labelTapaaq->project_id = 999;
        // // $labelTapaaq->parent_id = null;
        // $labelTapaaq->labeled = true;
        // $labelTapaaq->icon = null;

        $labelTapaaq = new Module();
        $labelTapaaq->name = 'Taapaq';
        $labelTapaaq->url = null;
        $labelTapaaq->labeled = true;

        $moduleCompany = new Module();
        $moduleCompany->name = 'Companies';
        $moduleCompany->url = '/company-list';
        $moduleCompany->icon = null;
        $moduleCompany->resources = ResourceSeeder::getResourceCommons();

        $moduleProject = new Module();
        $moduleProject->name = 'Projects';
        $moduleProject->url = '/project-list';
        $moduleProject->icon = null;
        $moduleProject->resources = ResourceSeeder::getForProjectModule();

        $moduleModule = new Module();
        $moduleModule->name = 'Modules';
        $moduleModule->url = '/module-list';
        $moduleModule->icon = null;
        $moduleModule->resources = ResourceSeeder::getResourceCommons();

        $moduleResource = new Module();
        $moduleResource->name = 'Resources';
        $moduleResource->url = '/resource-list';
        $moduleResource->icon = null;
        $moduleResource->resources = ResourceSeeder::getResourceCommons();

        $moduleRole = new Module();
        $moduleRole->name = 'Roles';
        $moduleRole->url = '/role-list';
        $moduleRole->icon = null;
        $moduleRole->resources = ResourceSeeder::getForRoleModule();

        $moduleUser = new Module();
        $moduleUser->name = 'Users';
        $moduleUser->url = '/user-list';
        $moduleUser->icon = null;
        $moduleUser->resources = ResourceSeeder::getForUserModule();

        $moduleUniversalPerson = new Module();
        $moduleUniversalPerson->name = 'Universal Persons';
        $moduleUniversalPerson->url = '/user-detail-list';
        $moduleUniversalPerson->icon = null;
        $moduleUniversalPerson->resources = ResourceSeeder::getResourceCommons();

        $modulePermission = new Module();
        $modulePermission->name = 'Permissions';
        $modulePermission->url = '/permission-list';
        $modulePermission->icon = null;
        $modulePermission->resources = ResourceSeeder::getResourceCommons();

        $moduleModel = new Module();
        $moduleModel->name = 'Models';
        $moduleModel->url = '/model-list';
        $moduleModel->icon = null;
        $moduleModel->resources = ResourceSeeder::getResourceCommons();

        $moduleTranslation = new Module();
        $moduleTranslation->name = 'Translations';
        $moduleTranslation->url = 'translation-list';
        $moduleTranslation->icon = null;
        $moduleTranslation->resources = ResourceSeeder::getResourceCommons();

        $labelTapaaq->children = [ $moduleCompany,
                                   $moduleProject,
                                   $moduleModule,
                                   $moduleResource,
                                   $moduleRole,
                                   $moduleUser,
                                   $moduleUniversalPerson,
                                   $modulePermission,
                                   $moduleModel,
                                   $moduleTranslation,
                                 ];

        $arrayTaapaq = [$labelTapaaq];

        return $arrayTaapaq;
    }
 
}
