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

        ModuleUtil::createMassiveFromProjectCode(env('PROJECT_RANQHANA_CODE'),self::getForRanqhana());
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
        $labelTapaaq->icon = 'start';

        $moduleCompany = new Module();
        $moduleCompany->name = 'Companies';
        $moduleCompany->url = '/company-list';
        $moduleCompany->icon = 'business';
        $moduleCompany->resources = ResourceSeeder::getResourceCommons();

        $moduleProject = new Module();
        $moduleProject->name = 'Projects';
        $moduleProject->url = '/project-list';
        $moduleProject->icon = 'apps';
        $moduleProject->resources = ResourceSeeder::getForProjectModule();

        $moduleModule = new Module();
        $moduleModule->name = 'Modules';
        $moduleModule->url = '/module-list';
        $moduleModule->icon = 'build';
        $moduleModule->resources = ResourceSeeder::getResourceCommons();

        $moduleResource = new Module();
        $moduleResource->name = 'Resources';
        $moduleResource->url = '/resource-list';
        $moduleResource->visibled = false;
        $moduleResource->icon = null;
        $moduleResource->resources = ResourceSeeder::getResourceCommons();

        $moduleRole = new Module();
        $moduleRole->name = 'Roles';
        $moduleRole->url = '/role-list';
        $moduleRole->icon = 'document';
        $moduleRole->resources = ResourceSeeder::getForRoleModule();

        $moduleUser = new Module();
        $moduleUser->name = 'Users';
        $moduleUser->url = '/user-list';
        $moduleUser->icon = 'person';
        $moduleUser->resources = ResourceSeeder::getForUserModule();

        $moduleUniversalPerson = new Module();
        $moduleUniversalPerson->name = 'Persons';
        $moduleUniversalPerson->url = '/user-detail-list';
        $moduleUniversalPerson->icon = 'people';
        $moduleUniversalPerson->resources = ResourceSeeder::getResourceCommons();

        $modulePermission = new Module();
        $modulePermission->name = 'Permissions';
        $modulePermission->url = '/permission-list';
        $modulePermission->visibled = false;
        $modulePermission->icon = null;
        $modulePermission->resources = ResourceSeeder::getResourceCommons();

        $moduleModel = new Module();
        $moduleModel->name = 'Models';
        $moduleModel->url = '/model-list';
        $moduleModel->icon = 'albums';
        $moduleModel->resources = ResourceSeeder::getResourceCommons();

        $moduleTranslation = new Module();
        $moduleTranslation->name = 'Translations';
        $moduleTranslation->url = 'translation-list';
        $moduleTranslation->icon = 'language';
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

    static function getForRanqhana(){

        /**
         * Label TAAPAQ and its
         */
        $labelTapaaq = new Module();
        $labelTapaaq->name = 'Taapaq';
        $labelTapaaq->url = null;
        $labelTapaaq->labeled = true;
        $labelTapaaq->icon = 'tools';

        $moduleCompany = new Module();
        $moduleCompany->name = 'Roles';
        $moduleCompany->url = '/role-list';
        $moduleCompany->icon = 'document';
        $moduleCompany->resources = ResourceSeeder::getResourceCommons();

        $moduleUniversalPerson = new Module();
        $moduleUniversalPerson->name = 'Persons';
        $moduleUniversalPerson->url = '/user-detail-list';
        $moduleUniversalPerson->icon = 'people';
        $moduleUniversalPerson->resources = ResourceSeeder::getResourceCommons();

        $modulePermission = new Module();
        $modulePermission->name = 'Permissions';
        $modulePermission->url = '/permission-list';
        $modulePermission->visibled = false;
        $modulePermission->icon = null;
        $modulePermission->resources = ResourceSeeder::getResourceCommons();

        $moduleUser = new Module();
        $moduleUser->name = 'Users';
        $moduleUser->url = '/user-list';
        $moduleUser->icon = 'person';
        $moduleUser->resources = ResourceSeeder::getForUserModule();

        $labelTapaaq->children = [ $moduleCompany,
                                   $moduleUniversalPerson,
                                   $modulePermission,
                                   $moduleUser,
        ];

        /**
         * DASHBOARD module
         */

        $moduleDashboard = new Module();
        $moduleDashboard->name = 'Dashboard';
        $moduleDashboard->url = '/dashboard';
        $moduleDashboard->icon = 'tachometer-alt';
        $moduleDashboard->resources = ResourceSeeder::getResourceCommonsForListPage();


        /**
         * Label INVOICE and its
         */

        $labelInvoice = new Module();
        $labelInvoice->name = 'Invoices';
        $labelInvoice->url = null;
        $labelInvoice->labeled = true;
        $labelInvoice->icon = 'file-invoice-dollar';

        $moduleInvoiceList = new Module();
        $moduleInvoiceList->name = 'Invoices List';
        $moduleInvoiceList->url = '/invoices';
        $moduleInvoiceList->icon = 'table';
        $moduleInvoiceList->resources = ResourceSeeder::getResourceCommonsForListPage();

        $moduleSellInvoice = new Module();
        $moduleSellInvoice->name = 'Sell Invoice';
        $moduleSellInvoice->url = '/invoices/sell';
        $moduleSellInvoice->icon = 'file-invoice-dollar';
        $moduleSellInvoice->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $modulePurchaseInvoice = new Module();
        $modulePurchaseInvoice->name = 'Purchase Invoice';
        $modulePurchaseInvoice->url = '/invoices/purchase';
        $modulePurchaseInvoice->icon = 'file-invoice-dollar';
        $modulePurchaseInvoice->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $moduleInvoiceChart = new Module();
        $moduleInvoiceChart->name = 'Invoices Chart';
        $moduleInvoiceChart->url = '/invoices/chart';
        $moduleInvoiceChart->icon = 'chart-area';
        $moduleInvoiceChart->resources = ResourceSeeder::getResourceCommonsForListPage();

        $labelInvoice->children = [ $moduleInvoiceList,
                                    $moduleSellInvoice,
                                    $modulePurchaseInvoice,
                                    $moduleInvoiceChart,
        ];
        /**
         * Label ORDER and its
         */

        $labelOrder = new Module();
        $labelOrder->name = 'Orders';
        $labelOrder->url = null;
        $labelOrder->labeled = true;
        $labelOrder->icon = 'file-invoice-dollar';

        $moduleOrderList = new Module();
        $moduleOrderList->name = 'Orders List';
        $moduleOrderList->url = '/orders/';
        $moduleOrderList->icon = '';
        $moduleOrderList->resources = ResourceSeeder::getResourceCommonsForListPage();

        $moduleSellOrder = new Module();
        $moduleSellOrder->name = 'Sell Order';
        $moduleSellOrder->url = '/orders/sell';
        $moduleSellOrder->icon = '';
        $moduleSellOrder->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $modulePurchaseOrder = new Module();
        $modulePurchaseOrder->name = 'Purchase Order';
        $modulePurchaseOrder->url = '/orders/purchase';
        $modulePurchaseOrder->icon = '';
        $modulePurchaseOrder->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $labelOrder->children = [ $moduleOrderList,
                                  $moduleSellOrder,
                                  $modulePurchaseOrder,
        ];

        /**
         * Label PRODUCT and its
         */

        $labelProduct = new Module();
        $labelProduct->name = 'Products';
        $labelProduct->url = null;
        $labelProduct->labeled = true;
        $labelProduct->icon = 'boxes';

        $moduleProductList = new Module();
        $moduleProductList->name = 'Products List';
        $moduleProductList->url = '/items/products';
        $moduleProductList->icon = 'table';
        $moduleProductList->resources = ResourceSeeder::getResourceCommonsForListPage();

        $moduleProduct = new Module();
        $moduleProduct->name = 'Product';
        $moduleProduct->url = '/items/product';
        $moduleProduct->icon = 'box';
        $moduleProduct->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $labelProduct->children = [ $moduleProductList,
                                    $moduleProduct,
        ];

        /**
        * Label SERVICE and its
        */

        $labelService = new Module();
        $labelService->name = 'Services';
        $labelService->url = null;
        $labelService->labeled = true;
        $labelService->icon = 'toolbox';

        $moduleServiceList = new Module();
        $moduleServiceList->name = 'Services List';
        $moduleServiceList->url = '/items/services';
        $moduleServiceList->icon = 'table';
        $moduleServiceList->resources = ResourceSeeder::getResourceCommonsForListPage();

        $moduleService = new Module();
        $moduleService->name = 'Service';
        $moduleService->url = '/items/service';
        $moduleService->icon = 'toolbox';
        $moduleService->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $labelService->children = [ $moduleServiceList,
                                    $moduleService,
        ];
        /**
        * Label USER and its
        */

        $labelUser = new Module();
        $labelUser->name = 'Users';
        $labelUser->url = null;
        $labelUser->labeled = true;
        $labelUser->icon = 'users';

        $moduleUserList = new Module();
        $moduleUserList->name = 'Users List';
        $moduleUserList->url = '/users';
        $moduleUserList->icon = 'table';
        $moduleUserList->resources = ResourceSeeder::getResourceCommonsForListPage();

        $moduleUser = new Module();
        $moduleUser->name = 'User';
        $moduleUser->url = '/users/user';
        $moduleUser->icon = 'user';
        $moduleUser->resources = ResourceSeeder::getResourceCommonsForSimplePage();

        $labelUser->children = [ $moduleUserList,
                                 $moduleUser,
        ];

         /**
         * Payment module
         */
        $modulePayment = new Module();
        $modulePayment->name = 'Payment';
        $modulePayment->url = '/payment';
        $modulePayment->visibled = false;
        // $modulePayment->icon = 'tachometer-alt';
        $modulePayment->resources = ResourceSeeder::getResourceCommons();


        //final array
        $arrayRanqhana = [
            $labelTapaaq,
            $moduleDashboard,
            $labelInvoice,
            $labelOrder,
            $labelProduct,
            $labelService,
            $labelUser,
            $modulePayment,
        ];

        return $arrayRanqhana;
    }
 
}

// $module = new Module();
// $module->name = '';
// $module->url = '/';
// $module->icon = '';
// $module->resources = ResourceSeeder::getForUserModule();
