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
        // ModuleUtil::createMassiveFromProjectCode(env('PROJECT_TAAPAQ_CODE'),self::getForTaapaq());

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
        $moduleCompany->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Empresas', 'locale' => 'es'),
                                    (object) array('value' => 'Companhias', 'locale' => 'pt')]
                            );

        $moduleProject = new Module();
        $moduleProject->name = 'Projects';
        $moduleProject->url = '/project-list';
        $moduleProject->icon = 'apps';
        $moduleProject->resources = ResourceSeeder::getForProjectModule();
        $moduleProject->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Projectos', 'locale' => 'es'),
                                    (object) array('value' => 'Projetos', 'locale' => 'pt')]
                            );

        $moduleModule = new Module();
        $moduleModule->name = 'Modules';
        $moduleModule->url = '/module-list';
        $moduleModule->icon = 'build';
        $moduleModule->resources = ResourceSeeder::getResourceCommons();
        $moduleModule->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Modulos', 'locale' => 'es'),
                                    (object) array('value' => 'Modulos', 'locale' => 'pt')]
                            );

        $moduleResource = new Module();
        $moduleResource->name = 'Resources';
        $moduleResource->url = '/resource-list';
        $moduleResource->visibled = false;
        $moduleResource->icon = null;
        $moduleResource->resources = ResourceSeeder::getResourceCommons();
        $moduleResource->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Recursos', 'locale' => 'es'),
                                    (object) array('value' => 'Recursos', 'locale' => 'pt')]
                            );

        $moduleRole = new Module();
        $moduleRole->name = 'Roles';
        $moduleRole->url = '/role-list';
        $moduleRole->icon = 'document';
        $moduleRole->resources = ResourceSeeder::getForRoleModule();
        $moduleRole->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Roles', 'locale' => 'es'),
                                    (object) array('value' => 'Roles', 'locale' => 'pt')]
                            );

        $moduleUser = new Module();
        $moduleUser->name = 'Users';
        $moduleUser->url = '/user-list';
        $moduleUser->icon = 'person';
        $moduleUser->resources = ResourceSeeder::getForUserModule();
        $moduleUser->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Usuarios', 'locale' => 'es'),
                                    (object) array('value' => 'Usuários', 'locale' => 'pt')]
                            );

        $moduleUniversalPerson = new Module();
        $moduleUniversalPerson->name = 'Persons';
        $moduleUniversalPerson->url = '/user-detail-list';
        $moduleUniversalPerson->icon = 'people';
        $moduleUniversalPerson->resources = ResourceSeeder::getResourceCommons();
        $moduleUniversalPerson->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Personas', 'locale' => 'es'),
                                    (object) array('value' => 'Pessoas', 'locale' => 'pt')]
                            );

        $modulePermission = new Module();
        $modulePermission->name = 'Permissions';
        $modulePermission->url = '/permission-list';
        $modulePermission->visibled = false;
        $modulePermission->icon = null;
        $modulePermission->resources = ResourceSeeder::getResourceCommons();
        $modulePermission->translation =
        (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Permisos', 'locale' => 'es'),
                                    (object) array('value' => 'Permissões ', 'locale' => 'pt')]
                            );                    

        $moduleModel = new Module();
        $moduleModel->name = 'Models';
        $moduleModel->url = '/model-list';
        $moduleModel->icon = 'albums';
        $moduleModel->resources = ResourceSeeder::getResourceCommons();
        $moduleModel->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Modelos', 'locale' => 'es'),
                                    (object) array('value' => 'Modelos ', 'locale' => 'pt')]
                            );     

        $moduleTranslation = new Module();
        $moduleTranslation->name = 'Translations';
        $moduleTranslation->url = 'translation-list';
        $moduleTranslation->icon = 'language';
        $moduleTranslation->resources = ResourceSeeder::getResourceCommons();
        $moduleTranslation->translation =
        (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Traducciones', 'locale' => 'es'),
                                    (object) array('value' => 'Traducões ', 'locale' => 'pt')]
                            ); 

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
        $moduleCompany->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Roles', 'locale' => 'es'),
                                    (object) array('value' => 'Roles', 'locale' => 'pt')]
                            );

        $moduleUniversalPerson = new Module();
        $moduleUniversalPerson->name = 'Persons';
        $moduleUniversalPerson->url = '/user-detail-list';
        $moduleUniversalPerson->icon = 'people';
        $moduleUniversalPerson->resources = ResourceSeeder::getResourceCommons();
        $moduleUniversalPerson->translation =
                                    (object) array('key' => 'nickname',
                                    'details' => [
                                            (object) array('value' => 'Personas', 'locale' => 'es'),
                                            (object) array('value' => 'Pessoa', 'locale' => 'pt')]
                                    );

        $modulePermission = new Module();
        $modulePermission->name = 'Permissions';
        $modulePermission->url = '/permission-list';
        $modulePermission->visibled = false;
        $modulePermission->icon = null;
        $modulePermission->resources = ResourceSeeder::getResourceCommons();
        $modulePermission->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Permisos', 'locale' => 'es'),
                                    (object) array('value' => 'Permissões', 'locale' => 'pt')]
                            );

        $moduleUser = new Module();
        $moduleUser->name = 'Users';
        $moduleUser->url = '/user-list';
        $moduleUser->icon = 'person';
        $moduleUser->resources = ResourceSeeder::getForUserModule();
        $moduleUser->translation =
                        (object) array('key' => 'nickname',
                        'details' => [
                                (object) array('value' => 'Usuarios', 'locale' => 'es'),
                                (object) array('value' => 'Usuarios', 'locale' => 'pt')]
                        );

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
        $moduleDashboard->resources = ResourceSeeder::getResourceCommonsOnlyRead();


        /**
         * Label INVOICE and its
         */

        $labelInvoice = new Module();
        $labelInvoice->name = 'Invoices';
        $labelInvoice->url = null;
        $labelInvoice->labeled = true;
        $labelInvoice->icon = 'file-invoice-dollar';
        $labelInvoice->translation =
                        (object) array('key' => 'nickname',
                        'details' => [
                                (object) array('value' => 'Facturas', 'locale' => 'es'),
                                (object) array('value' => 'Faturas', 'locale' => 'pt')]
                        );

        $moduleInvoiceList = new Module();
        $moduleInvoiceList->name = 'Invoices List';
        $moduleInvoiceList->url = '/invoices';
        $moduleInvoiceList->icon = 'table';
        $moduleInvoiceList->resources = ResourceSeeder::getResourceCommonsForListPage();
        $moduleInvoiceList->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Lista de facturas', 'locale' => 'es'),
                                        (object) array('value' => 'Relatório de faturas', 'locale' => 'pt')]
                                );

        $moduleSellInvoice = new Module();
        $moduleSellInvoice->name = 'Sell Invoice';
        $moduleSellInvoice->url = '/invoices/sell';
        $moduleSellInvoice->icon = 'file-invoice-dollar';
        $moduleSellInvoice->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $moduleSellInvoice->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Factura de venta', 'locale' => 'es'),
                                    (object) array('value' => 'Factura de venda', 'locale' => 'pt')]
                            );

        $modulePurchaseInvoice = new Module();
        $modulePurchaseInvoice->name = 'Purchase Invoice';
        $modulePurchaseInvoice->url = '/invoices/purchase';
        $modulePurchaseInvoice->icon = 'file-invoice-dollar';
        $modulePurchaseInvoice->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $modulePurchaseInvoice->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Factura de compra', 'locale' => 'es'),
                                        (object) array('value' => 'Factura de compra', 'locale' => 'pt')]
                                );


        $labelInvoice->children = [ $moduleInvoiceList,
                                    $moduleSellInvoice,
                                    $modulePurchaseInvoice,
        ];
        /**
         * Label ORDER and its
         */

        $labelOrder = new Module();
        $labelOrder->name = 'Orders';
        $labelOrder->url = null;
        $labelOrder->labeled = true;
        $labelOrder->icon = 'file-invoice-dollar';
        $labelOrder->translation =
                        (object) array('key' => 'nickname',
                        'details' => [
                                (object) array('value' => 'Pedidos', 'locale' => 'es'),
                                (object) array('value' => 'Pedidos', 'locale' => 'pt')]
                        );


        $moduleOrderList = new Module();
        $moduleOrderList->name = 'Orders List';
        $moduleOrderList->url = '/orders/';
        $moduleOrderList->icon = '';
        $moduleOrderList->resources = ResourceSeeder::getResourceCommonsForListPage();
        $moduleOrderList->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Lista de Pedidos', 'locale' => 'es'),
                                    (object) array('value' => 'Relatório de Pedidos', 'locale' => 'pt')]
                            );

        $moduleSellOrder = new Module();
        $moduleSellOrder->name = 'Sell Order';
        $moduleSellOrder->url = '/orders/sell';
        $moduleSellOrder->icon = '';
        $moduleSellOrder->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $moduleSellOrder->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Pedido de venta', 'locale' => 'es'),
                                    (object) array('value' => 'Pedido de venda', 'locale' => 'pt')]
                            );

        $modulePurchaseOrder = new Module();
        $modulePurchaseOrder->name = 'Purchase Order';
        $modulePurchaseOrder->url = '/orders/purchase';
        $modulePurchaseOrder->icon = '';
        $modulePurchaseOrder->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $modulePurchaseOrder->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Pedido de compra', 'locale' => 'es'),
                                        (object) array('value' => 'Pedido de compra', 'locale' => 'pt')]
                                );

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
        $labelProduct->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Productos', 'locale' => 'es'),
                                    (object) array('value' => 'Produtos', 'locale' => 'pt')]
                            );

        $moduleProductList = new Module();
        $moduleProductList->name = 'Products List';
        $moduleProductList->url = '/items/products';
        $moduleProductList->icon = 'table';
        $moduleProductList->resources = ResourceSeeder::getResourceCommonsForListPage();
        $moduleProductList->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Lista de productos', 'locale' => 'es'),
                                        (object) array('value' => 'Relatório de produtos', 'locale' => 'pt')]
                                );

        $moduleProduct = new Module();
        $moduleProduct->name = 'Product';
        $moduleProduct->url = '/items/product';
        $moduleProduct->icon = 'box';
        $moduleProduct->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $moduleProduct->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Producto', 'locale' => 'es'),
                                    (object) array('value' => 'Produto', 'locale' => 'pt')]
                            );

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
        $labelService->translation =
                        (object) array('key' => 'nickname',
                        'details' => [
                                (object) array('value' => 'Servicios', 'locale' => 'es'),
                                (object) array('value' => 'Serviços', 'locale' => 'pt')]
                        );

        $moduleServiceList = new Module();
        $moduleServiceList->name = 'Services List';
        $moduleServiceList->url = '/items/services';
        $moduleServiceList->icon = 'table';
        $moduleServiceList->resources = ResourceSeeder::getResourceCommonsForListPage();
        $moduleServiceList->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Lista de servicios', 'locale' => 'es'),
                                    (object) array('value' => 'Relatório de serviços', 'locale' => 'pt')]
                            );

        $moduleService = new Module();
        $moduleService->name = 'Service';
        $moduleService->url = '/items/service';
        $moduleService->icon = 'toolbox';
        $moduleService->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $moduleService->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Servicio', 'locale' => 'es'),
                                    (object) array('value' => 'Serviço', 'locale' => 'pt')]
                            );

        $labelService->children = [ $moduleServiceList,
                                    $moduleService,
        ];



        /**
         * Reports
         */

        $labelReport = new Module();
        $labelReport->name = 'Reports';
        $labelReport->url = null;
        $labelReport->labeled = true;
        $labelReport->icon = 'chart-area';
        $labelReport->translation =
                        (object) array('key' => 'nickname',
                        'details' => [
                                (object) array('value' => 'Reportes', 'locale' => 'es'),
                                (object) array('value' => 'Relatórios', 'locale' => 'pt')]
                        );


        $InvoiceMoneyByPaymentType = new Module();
        $InvoiceMoneyByPaymentType->name = 'Invoice $$$ by Payment Type';
        $InvoiceMoneyByPaymentType->url = '/reports/invoice-money-by-payment-type';
        $InvoiceMoneyByPaymentType->icon = 'chart-area';
        $InvoiceMoneyByPaymentType->resources =  ResourceSeeder::getResourceCommonsOnlyRead();
        $InvoiceMoneyByPaymentType->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Facturas $$$ Tipo de pagamento', 'locale' => 'es'),
                                        (object) array('value' => 'Faturas $$$ Tipo de pagamento', 'locale' => 'pt')]
                                );

        $InvoiceMoneyByPeriod = new Module();
        $InvoiceMoneyByPeriod->name = 'Invoice $$$ by Period';
        $InvoiceMoneyByPeriod->url = '/reports/invoice-money-by-period';
        $InvoiceMoneyByPeriod->icon = 'chart-area';
        $InvoiceMoneyByPeriod->resources =  ResourceSeeder::getResourceCommonsOnlyRead();
        $InvoiceMoneyByPeriod->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Facturas $$$ por período', 'locale' => 'es'),
                                        (object) array('value' => 'Faturas $$$ por período', 'locale' => 'pt')]
                                );

        $labelReport->children = [ $InvoiceMoneyByPaymentType,
                                   $InvoiceMoneyByPeriod
                                ];

        /**
        * Label USER and its
        */

        $labelUser = new Module();
        $labelUser->name = 'Persons';
        $labelUser->url = null;
        $labelUser->labeled = true;
        $labelUser->icon = 'users';
        $labelUser->translation =
                        (object) array('key' => 'nickname',
                        'details' => [
                                (object) array('value' => 'Personas', 'locale' => 'es'),
                                (object) array('value' => 'Pessoas', 'locale' => 'pt')]
                        );

        $moduleMyUserList = new Module();
        $moduleMyUserList->name = 'My Users List';
        $moduleMyUserList->url = '/users';
        $moduleMyUserList->icon = 'table';
        $moduleMyUserList->resources = ResourceSeeder::getResourceCommonsForListPage();
        $moduleMyUserList->translation =
                            (object) array('key' => 'nickname',
                            'details' => [
                                    (object) array('value' => 'Mis usuarios', 'locale' => 'es'),
                                    (object) array('value' => 'Meus usuários', 'locale' => 'pt')]
                            );

        $moduleCompanyList = new Module();
        $moduleCompanyList->name = 'Company List';
        $moduleCompanyList->url = '/persons';
        $moduleCompanyList->icon = 'table';
        $moduleCompanyList->resources = ResourceSeeder::getResourceCommonsForListPage();
        $moduleCompanyList->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Lista de compañias', 'locale' => 'es'),
                                        (object) array('value' => 'Relatório de companias', 'locale' => 'pt')]
                                );

        $modulePerson = new Module();
        $modulePerson->name = 'Person';
        $modulePerson->url = '/persons/person';
        $modulePerson->icon = 'user';
        $modulePerson->resources = ResourceSeeder::getResourceCommonsForSimplePage();
        $modulePerson->translation =
                                (object) array('key' => 'nickname',
                                'details' => [
                                        (object) array('value' => 'Persona', 'locale' => 'es'),
                                        (object) array('value' => 'Pessoa', 'locale' => 'pt')]
                                );

        $labelUser->children = [ $moduleMyUserList,
                                 $modulePerson,
                                 $moduleCompanyList,
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
            $labelReport,
        ];


        return self::orderArray($arrayRanqhana);
    }


    static function orderArray($modules){

        $newModules = array();
        foreach ($modules as $key=>$module) {
                $module['order'] = $key + 1;

                if(count($module['children']) > 0){
                        $module['children'] = self::orderArray($module['children']);
                }

                array_push($newModules,(object) $module);     
        }

        return $newModules; 

    }
 
}

// $module = new Module();
// $module->name = '';
// $module->url = '/';
// $module->icon = '';
// $module->resources = ResourceSeeder::getForUserModule();
