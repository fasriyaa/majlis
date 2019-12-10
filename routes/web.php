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
    return redirect('/dashboard/home');
});

Route::group(['middleware' => ['role:SCMember|Admin']], function () {
    Route::get('/gantt', function () {return view('gantt.gantt');});
    Route::get('/gantt/w', function () {return view('gantt.gantt_month');});
    Route::get('/gantt/m', function () {return view('gantt.gantt_month');});
    Route::get('/gantt/y', function () {return view('gantt.gantt_year');});
});

Route::group(['middleware' => ['role:SCMember|Admin']], function () {
    Route::resource('progress', '\App\Http\Controllers\Progress\ProgressController');
    Route::get('/procurement/ongoing', function () {return view('procurements.ongoing');});
    Route::get('/procurement/awarded', function () {return view('procurements.awarded');});
    Route::resource('procurement', '\App\Http\Controllers\Progress\ProgressController');
    Route::get('/discussions/sclist', function () {return view('discussions.sclist');});
    Route::get('/discussions/sc/1', function () {return view('discussions.sc');});
    Route::get('/discussions/tclist', function () {return view('discussions.tclist');});
    Route::get('/discussions/tc/1', function () {return view('discussions.tc');});
    Route::get('/resultframework/pdo', function () {return view('resultframework.pdo');});
    Route::get('/resultframework/intermediate', function () {return view('resultframework.intermediate');});
    Route::get('/resultframework/dli', function () {return view('resultframework.dli');});
});

Route::group(['middleware' => ['permission:PMU']], function () {
    Route::get('/components', '\App\Http\Controllers\PMU\PmuController@components') -> name('pmu.components');
    Route::get('/subcomponent/{id}', '\App\Http\Controllers\PMU\PmuController@subcomponent') -> name('pmu.subcomponent');
    Route::get('/activity/{id}', '\App\Http\Controllers\PMU\PmuController@activity') -> name('pmu.activity');
    Route::get('/subactivity/{id}', '\App\Http\Controllers\PMU\PmuController@subactivity') -> name('pmu.subactivity');
    Route::get('/task/{id}', '\App\Http\Controllers\PMU\PmuController@task') -> name('pmu.task');
    Route::get('/subtask/{id}', '\App\Http\Controllers\PMU\PmuController@subtask') -> name('pmu.subtask');

    Route::get('/subcomponents', '\App\Http\Controllers\PMU\PmuController@subcomponents') -> name('pmu.subcomponents');
    Route::get('/activities', '\App\Http\Controllers\PMU\PmuController@activities') -> name('pmu.activities');
    Route::get('/subactivities', '\App\Http\Controllers\PMU\PmuController@subactivities') -> name('pmu.subactivities');
    Route::get('/tasks', '\App\Http\Controllers\PMU\PmuController@tasks') -> name('pmu.tasks');

    Route::get('/timeline', function () {return view('pmu.timeline');});
    Route::get('/assign_staff/{subtask_id}/{staff_id}', '\App\Http\Controllers\PMU\PmuController@assign_staff') -> name('pmu.assign_staff');
});

Route::group(['middleware' => ['role:Editor|Admin']], function () {
    Route::get('/update_progress/{subtask_id}/{progress}', '\App\Http\Controllers\PMU\PmuController@update_progress') -> name('pmu.update_progress');
    Route::get('/my_tasks', '\App\Http\Controllers\PMU\PmuController@my_tasks') -> name('pmu.my_tasks');
    Route::get('/task_timeline/{id}', '\App\Http\Controllers\PMU\PmuController@task_timeline') -> name('pmu.task_timeline');
    Route::get('/assign_approval_staff/{task_id}/{staff_id}', '\App\Http\Controllers\PMU\PmuController@assign_approval_staff') -> name('pmu.assign_approval_staff');
    Route::get('/cancel_approval/{id}', '\App\Http\Controllers\PMU\PmuController@cancel_approval') -> name('pmu.cancel_approval');
    Route::get('/approve/{id}/{comment}', '\App\Http\Controllers\PMU\PmuController@approve') -> name('pmu.approve');
    Route::get('/require_doc/{id}', '\App\Http\Controllers\PMU\PmuController@require_doc') -> name('pmu.require_doc');
    Route::get('/cancel_doc/{id}', '\App\Http\Controllers\PMU\PmuController@cancel_doc') -> name('pmu.cancel_doc');
    Route::post('/upload_doc', '\App\Http\Controllers\PMU\PmuController@upload_doc') -> name('pmu.upload_doc');


});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


Auth::routes();


Route::group(['middleware' => ['role:SCMember|Admin']], function () {
      Route::get('/dashboard/home', 'DashboardController@versionone')->name('home');
      Route::get('/dashboard/v2', 'DashboardController@versiontwo')->name('v2');
      Route::get('/dashboard/v3', 'DashboardController@versionthree')->name('v3');
});




Route::group(['middleware' => ['role:Admin']], function () {
          Route::get('/users', 'HomeController@users')->name('users');
          Route::resource('main_modules', '\App\Http\Controllers\Modules\MainModulesController');
          Route::resource('roles', '\App\Http\Controllers\Permissions\RolesController');
          Route::resource('permissions', '\App\Http\Controllers\Permissions\PermissionsController');
          Route::get('assing_permission/{role}/{permission}','\App\Http\Controllers\Permissions\PermissionsController@assign_permission')->name('assing_permission');
          Route::get('assing_role/{user}/{role}','\App\Http\Controllers\Permissions\PermissionsController@assign_role')->name('assing_role');
});
