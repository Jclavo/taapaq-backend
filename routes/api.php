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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Users
Route::post('login', 'UserController@login');
Route::get('users/withRoles', 'UserController@withRoles');
Route::resource('users', 'UserController');
Route::post('users/assignRole', 'UserController@assignRole');
Route::post('users/removeRole', 'UserController@removeRole');


//Roles
Route::resource('roles', 'RoleController');
Route::get('roles/missingToUser/{user_id}', 'RoleController@missingToUser');
Route::post('roles/givePermissionTo', 'RoleController@givePermissionTo');
Route::post('roles/revokePermissionTo', 'RoleController@revokePermissionTo');
Route::post('roles/byUser', 'RoleController@byUser');


//Permissions
Route::resource('permissions', 'PermissionController');
Route::post('permissions/getAllByRole', 'PermissionController@getAllByRole');

//Projects
Route::resource('projects', 'ProjectController');

