<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('gantt.gantt');
});

Route::get('/gantt', function () {
    return view('gantt.gantt');
});

Auth::routes();

Route::get('/dashboard/home', 'DashboardController@versionone')->name('home');
Route::get('/dashboard/v2', 'DashboardController@versiontwo')->name('v2');
Route::get('/dashboard/v3', 'DashboardController@versionthree')->name('v3');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


    Route::resource('main_modules', '\App\Http\Controllers\Modules\MainModulesController');
    Route::resource('roles', '\App\Http\Controllers\Permissions\RolesController');
    Route::resource('permissions', '\App\Http\Controllers\Permissions\PermissionsController');
    Route::get('assing_permission/{role}/{permission}','\App\Http\Controllers\Permissions\PermissionsController@assign_permission')->name('assing_permission');
    Route::get('assing_role/{user}/{role}','\App\Http\Controllers\Permissions\PermissionsController@assign_role')->name('assing_role');
