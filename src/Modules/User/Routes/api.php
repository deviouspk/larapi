<?php

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

use Modules\Authorization\Entities\Permission;

Route::get('/me', 'UserController@show');
Route::patch('/{id}', 'UserController@update')->middleware(['permission:' . Permission::ASSIGN_ROLES]);
Route::get('/', 'UserController@index')->middleware(['permission:' . Permission::INDEX_USERS]);
