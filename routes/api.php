<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'UserController@login');
Route::post('changePassword', 'UserController@changePassword');

// Locales
Route::resource('locales', 'LocaleController');

Route::middleware(['auth:api'])->group(function () {

    //Users
    Route::get('logout', 'UserController@logout');
    Route::get('users/roles/companies/{company_id}/projects/{project_id}', 'UserController@UserRolesByProjectCompany');
    Route::get('users/{user_id}/changeActivatedStatus', 'UserController@changeActivatedStatus');
    Route::post('users/assignRole', 'UserController@assignRole');
    Route::post('users/assignMassiveRole', 'UserController@assignMassiveRole');
    Route::post('users/removeRole', 'UserController@removeRole');
    Route::post('users/pagination', 'UserController@pagination');

    Route::resource('users', 'UserController');
    
    
    //Roles
    Route::get('roles/not/users/{user_id}', 'RoleController@notInUser');
    // Route::get('roles/projects/{project_id}', 'RoleController@byProject');
    Route::get('roles/companies/{company_id}/projects/{project_id}/', 'RoleController@byCompanyProject');
    Route::post('roles/byUser', 'RoleController@byUser');
    Route::post('roles/givePermissionTo', 'RoleController@givePermissionTo');
    Route::post('roles/givePermissionTo', 'RoleController@givePermissionTo');
    Route::post('roles/giveAllPermissionTo', 'RoleController@giveAllPermissionTo');
    Route::resource('roles', 'RoleController');


    //Permissions
    Route::get('permissions/roles/{role_id}', 'PermissionController@getByRole');
    Route::resource('permissions', 'PermissionController');
    

    //Projects
    Route::get('projects/companies', 'ProjectController@companies');
    Route::get('projects/{project_id}/companies', 'ProjectController@companiesByProject');
    Route::post('projects/assignCompany', 'ProjectController@assignCompany');
    Route::post('projects/removeCompany', 'ProjectController@removeCompany');
    Route::resource('projects', 'ProjectController');


    //Modules
    Route::get('modules/user', 'ModuleController@byUser');
    Route::get('modules/resources/projects/{project_id}', 'ModuleController@resourcesByProject');
    Route::get('modules/labels/projects/{project_id}', 'ModuleController@labelsByProject');
    Route::resource('modules', 'ModuleController');


    //Resource
    Route::resource('resources', 'ResourceController');


    //Resource Commons
    Route::resource('resource-commons', 'ResourceCommonController');


    //Company
    Route::get('companies/not/projects/{project_id}', 'CompanyController@NotInProject');
    Route::resource('companies', 'CompanyController');

    //User Details
    Route::resource('persons', 'UniversalPersonController');
    Route::post('persons/pagination', 'UniversalPersonController@pagination');

    //Company
    Route::resource('countries', 'CountryController');

    //Models
    Route::get('models/projects/{project_id}', 'SystemModelController@modelsByProject');
    Route::resource('models', 'SystemModelController');

    // Translations
    Route::get('translations/models/{model_id}', 'TranslationController@translationsByModel');
    Route::get('translations/models/projects/{project_id}', 'TranslationController@translationsByProject');
    Route::resource('translations', 'TranslationController');

    // Translation Details
    Route::get('translation-details/translations/{translation_id}', 'TranslationDetailController@detailsByTranslation');
    Route::post('getTranslation', 'TranslationDetailController@getTranslation');
    Route::resource('translation-details', 'TranslationDetailController');

    // Images
    // Route::resource('images', 'ImageController');
    Route::post('images/storePhysical', 'ImageController@storePhysical');
    Route::post('images/storeLogical', 'ImageController@storeLogical');
    Route::delete('images/destroyPhysical/{image}', 'ImageController@destroyPhysical');
    Route::delete('images/destroyLogical/{image}', 'ImageController@destroyLogical');

    // Person types
    Route::resource('person-types', 'PersonTypeController');
});



