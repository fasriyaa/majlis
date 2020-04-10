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
    return redirect('/dashboard/livefeed');
});

Route::group(['middleware' => ['role:Admin'], 'middleware' => 'auth'], function () {


});

Route::group(['middleware' => 'auth'], function () {






});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/gantt', function () {return view('gantt.gantt');});
    Route::get('/gantt/w', function () {return view('gantt.gantt_month');});
    Route::get('/gantt/m', function () {return view('gantt.gantt_month');});
    Route::get('/gantt/y', function () {return view('gantt.gantt_year');});
    Route::resource('profile', '\App\Http\Controllers\Auth\ProfileController');
    Route::post('/profile_pic', '\App\Http\Controllers\Auth\ProfileController@upload_profile_pic') -> name('profile.upload_pic');
    Route::post('/update_profile', '\App\Http\Controllers\Auth\ProfileController@update_profile') -> name('profile.update');
    Route::post('/profile/change_password', 'Auth\ProfileController@change_password')->name('profile.change_password');
    Route::get('/profile/reset_pws/{id}', 'Auth\ProfileController@reset_password')->name('profile.reset_pws');
    Route::post('/profile/reset_pws', 'Auth\ProfileController@store_password')->name('profile.store_pws');

    Route::get('/resultframework/pdo', function () {return view('resultframework.pdo');});
    Route::get('/resultframework/intermediate', function () {return view('resultframework.intermediate');});
    Route::get('/resultframework/dli', function () {return view('resultframework.dli');});

    Route::get('/dashboard/home', 'DashboardController@versionone')->name('home');
    Route::get('/dashboard/livefeed', 'DashboardController@livefeed')->name('livefeed');
    Route::get('/dashboard/v2', 'DashboardController@versiontwo')->name('v2');
    Route::get('/dashboard/v3', 'DashboardController@versionthree')->name('v3');
    Route::get('/critical', 'DashboardController@critical')->name('critical');

    Route::resource('main_modules', '\App\Http\Controllers\Modules\MainModulesController');
    Route::resource('roles', '\App\Http\Controllers\Permissions\RolesController');
    Route::get('/roles/attach_permission/{id}', '\App\Http\Controllers\Permissions\RolesController@attach_permission')->name('roles.attach_permission');
    Route::post('/roles/attach_permission)', '\App\Http\Controllers\Permissions\RolesController@attach_permission_store')->name('roles.attach_permission_store');
    Route::get('/roles/user/{id}', '\App\Http\Controllers\Permissions\RolesController@attach_user')->name('roles.attach_user');
    Route::post('/roles/user', '\App\Http\Controllers\Permissions\RolesController@attach_user_store')->name('roles.attach_user_store');
    Route::resource('permissions', '\App\Http\Controllers\Permissions\PermissionsController');
    Route::get('/permissions/attach_role/{id}', '\App\Http\Controllers\Permissions\PermissionsController@attach_role') -> name('permissions.attach_role');
    Route::post('/permissions/attach_role', '\App\Http\Controllers\Permissions\PermissionsController@attach_role_store') -> name('permissions.attach_role_store');
    Route::get('assign_permission/{role}/{permission}','\App\Http\Controllers\Permissions\PermissionsController@assign_permission')->name('assing_permission');
    Route::get('assign_role/{user}/{role}','\App\Http\Controllers\Permissions\PermissionsController@assign_role')->name('assing_role');

    Route::get('/users', 'HomeController@users')->name('users');

    Route::resource('/members', 'Members\MembersController');
    Route::resource('/meetings', 'Meetings\MeetingsController');



});


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/phpinfo', function () {return view('phpinfo');});
Route::get('/welcome','HomeController@welcome')->name('mail.user.welcome');

// Route::post('/otp/request', 'Procurements\VariationsController@generate_otp');

Auth::routes();
