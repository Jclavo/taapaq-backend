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

        $moduleProject = new Module();
        $moduleProject->name = 'Projects';
        $moduleProject->url = '/project-list';
        $moduleProject->icon = null;

        $moduleModule = new Module();
        $moduleModule->name = 'Modules';
        $moduleModule->url = '/module-list';
        $moduleModule->icon = null;

        $moduleResource = new Module();
        $moduleResource->name = 'Resources';
        $moduleResource->url = '/resource-list';
        $moduleResource->icon = null;

        $moduleRole = new Module();
        $moduleRole->name = 'Roles';
        $moduleRole->url = '/role-list';
        $moduleRole->icon = null;

        $moduleUser = new Module();
        $moduleUser->name = 'Users';
        $moduleUser->url = '/user-list';
        $moduleUser->icon = null;

        $moduleUniversalPerson = new Module();
        $moduleUniversalPerson->name = 'Universal Persons';
        $moduleUniversalPerson->url = '/user-detail-list';
        $moduleUniversalPerson->icon = null;

        $modulePermission = new Module();
        $modulePermission->name = 'Permissions';
        $modulePermission->url = '/permission-list';
        $modulePermission->icon = null;

        $moduleModel = new Module();
        $moduleModel->name = 'Models';
        $moduleModel->url = '/model-list';
        $moduleModel->icon = null;

        $moduleTranslation = new Module();
        $moduleTranslation->name = 'Translations';
        $moduleTranslation->url = 'translation-list';
        $moduleTranslation->icon = null;

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

        ModuleUtil::createMassiveFromProjectCode('A1',$arrayTaapaq);
                    
    }
 
}
