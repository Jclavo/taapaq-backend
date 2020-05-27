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
Route::resource('users', 'UserController');
Route::post('login', 'UserController@login');

//Roles
Route::resource('roles', 'RoleController');
Route::post('roles/givePermissionTo', 'RoleController@givePermissionTo');
Route::post('roles/revokePermissionTo', 'RoleController@revokePermissionTo');

//Permissions
Route::resource('permissions', 'PermissionController');
Route::post('permissions/getAllByRole', 'PermissionController@getAllByRole');

