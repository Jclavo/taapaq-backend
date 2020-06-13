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

Route::middleware(['auth:api'])->group(function () {

    //Users
    Route::get('users/withRoles', 'UserController@withRoles');
    Route::resource('users', 'UserController');
    Route::post('users/assignRole', 'UserController@assignRole');
    Route::post('users/removeRole', 'UserController@removeRole');
    Route::get('users/roles/companies/{company_id}/projects/{project_id}', 'UserController@UserRolesByProjectCompany');
    Route::get('users/{user_id}/changeActivatedStatus', 'UserController@changeActivatedStatus');
    Route::get('logout', 'UserController@logout');

    //Roles
    Route::resource('roles', 'RoleController');
    Route::get('roles/not/users/{user_id}/projects/{project_id}', 'RoleController@notInUser');
    Route::post('roles/givePermissionTo', 'RoleController@givePermissionTo');
    Route::post('roles/revokePermissionTo', 'RoleController@revokePermissionTo');
    Route::post('roles/byUser', 'RoleController@byUser');

    //Permissions
    Route::resource('permissions', 'PermissionController');
    Route::get('permissions/roles/{role_id}', 'PermissionController@getByRole');

    //Projects
    Route::get('projects/modules', 'ProjectController@modules');
    Route::get('projects/companies', 'ProjectController@companies');
    Route::get('projects/{project_id}/companies', 'ProjectController@companiesByProject');
    Route::get('projects/{project_id}/modules', 'ProjectController@modulesByProject');
    Route::get('projects/{project_id}/modules/resources', 'ProjectController@resources');
    Route::get('projects/{project_id}/roles', 'ProjectController@rolesByProject');
    Route::post('projects/assignCompany', 'ProjectController@assignCompany');
    Route::post('projects/removeCompany', 'ProjectController@removeCompany');
    Route::resource('projects', 'ProjectController');

    //Modules
    Route::resource('modules', 'ModuleController');
    Route::get('modules/{module_id}/resources', 'ModuleController@resourcesByModule');
    Route::get('modules/users/{user_id}', 'ModuleController@byUser');
    // Route::get('modules/resources/users/{user_id}', 'ModuleController@resourcesByUser');

    //Resource
    Route::resource('resources', 'ResourceController');
    Route::get('resources/{resource_id}/permission', 'ResourceController@permission');

    //Resource Commons
    Route::resource('resource-commons', 'ResourceCommonController');

    //Company
    Route::resource('companies', 'CompanyController');
    Route::get('companies/{company_id}/projects', 'CompanyController@projectsByCompany');
    Route::get('companies/{company_id}/users/roles', 'CompanyController@usersRolesByCompany');
    Route::get('companies/not/project/{project_id}', 'CompanyController@noCompanies');

    //User Details
    Route::resource('user-details', 'UserDetailController');
});



