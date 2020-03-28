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

});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('allocations', '\App\Http\Controllers\Budget\AllocationController');
    Route::resource('budget', '\App\Http\Controllers\Budget\BudgetController');

    Route::get('/sc_list', '\App\Http\Controllers\Discussions\DiscussionsController@sc_list')->name('sc.list');
    Route::post('/sc_list', '\App\Http\Controllers\Discussions\DiscussionsController@sc_list_store')->name('sc_list.store');
    Route::get('/sc/{id}', '\App\Http\Controllers\Discussions\DiscussionsController@sc_view')->name('sc.view');
    Route::resource('agenda', '\App\Http\Controllers\Discussions\DiscussionAgendaController');

    Route::resource('pmu_daily_list', '\App\Http\Controllers\Discussions\DiscussionsController');
    Route::get('/pmu_daily_meeting/{id}', '\App\Http\Controllers\Discussions\DiscussionsController@pmu_daily_meeting') -> name('pmu.daily.meeting');
    Route::post('/review', '\App\Http\Controllers\Discussions\DiscussionsController@review') -> name('pmu.review');
    Route::post('/new_comment', '\App\Http\Controllers\Discussions\DiscussionsController@new_comment') -> name('new.comment');
    Route::post('/add_participants', '\App\Http\Controllers\Discussions\DiscussionsController@add_participants') -> name('add.participants');
    Route::post('/close_discussion', '\App\Http\Controllers\Discussions\DiscussionsController@close_discussion') -> name('close.discussion');

    Route::resource('piu', '\App\Http\Controllers\PIU\PiuController');
    Route::get('/assign_piu/{task_id}/{piu_id}', '\App\Http\Controllers\PIU\PiuController@assign_piu') -> name('piu.assign_piu');
    Route::get('/piu_review_list', '\App\Http\Controllers\Discussions\DiscussionsController@piu_review_list')->name('piu.review_list');
    Route::post('/piu_review_list', '\App\Http\Controllers\Discussions\DiscussionsController@piu_review_list_store')->name('piu_review_list.store');
    Route::get('/piu_review_meeting/{id}', '\App\Http\Controllers\Discussions\DiscussionsController@piu_review_meeting') -> name('pmu.review.meeting');

    Route::get('/exco/{id}', '\App\Http\Controllers\Discussions\DiscussionsController@exco_view')->name('exco.view');
    Route::get('/exco_list', '\App\Http\Controllers\Discussions\DiscussionsController@exco_list')->name('exco.list');
    Route::post('/exco_review_list', '\App\Http\Controllers\Discussions\DiscussionsController@exco_review_list_store')->name('exco_review_list.store');

    Route::get('/tasks', '\App\Http\Controllers\PMU\PmuController@tasks') -> name('pmu.tasks');
    Route::get('/add_subtask/{id}', '\App\Http\Controllers\Gantt\TaskController@add_subtask') -> name('gantt.addSubtask');
    Route::get('/edit_subtask/{id}', '\App\Http\Controllers\Gantt\TaskController@edit_subtask') -> name('gantt.editSubtask');
    Route::post('/subitem', '\App\Http\Controllers\Gantt\TaskController@subitem_store') -> name('subitem.store');
    Route::post('/subitem_edit', '\App\Http\Controllers\Gantt\TaskController@subitem_edit') -> name('subitem.edit');
    Route::get('/reorder_task/{id}', '\App\Http\Controllers\Gantt\TaskController@reorder_task') -> name('gantt.reorder');
    Route::post('/sortorder/{id}/{index}', '\App\Http\Controllers\Gantt\TaskController@sortorder') -> name('gantt.sortorder');

    Route::get('/components', '\App\Http\Controllers\PMU\PmuController@components') -> name('pmu.components');
    Route::get('/subcomponent/{id}', '\App\Http\Controllers\PMU\PmuController@subcomponent') -> name('pmu.subcomponent');
    Route::get('/activity/{id}', '\App\Http\Controllers\PMU\PmuController@activity') -> name('pmu.activity');
    Route::get('/subactivity/{id}', '\App\Http\Controllers\PMU\PmuController@subactivity') -> name('pmu.subactivity');
    Route::get('/task/{id}', '\App\Http\Controllers\PMU\PmuController@task') -> name('pmu.task');
    Route::get('/subtask/{id}', '\App\Http\Controllers\PMU\PmuController@subtask') -> name('pmu.subtask');
    Route::get('/subcomponents', '\App\Http\Controllers\PMU\PmuController@subcomponents') -> name('pmu.subcomponents');
    Route::get('/activities', '\App\Http\Controllers\PMU\PmuController@activities') -> name('pmu.activities');
    Route::get('/subactivities', '\App\Http\Controllers\PMU\PmuController@subactivities') -> name('pmu.subactivities');
    Route::get('/assign_staff/{subtask_id}/{staff_id}', '\App\Http\Controllers\PMU\PmuController@assign_staff') -> name('pmu.assign_staff');
    Route::get('/to_task_timelie/{id}', '\App\Http\Controllers\PMU\PmuController@toTaskTimeline') -> name('pmu.toTaskTimeline');
    Route::get('/update_progress/{subtask_id}/{progress}', '\App\Http\Controllers\PMU\PmuController@update_progress') -> name('pmu.update_progress');
    Route::get('/my_tasks', '\App\Http\Controllers\PMU\PmuController@my_tasks') -> name('pmu.my_tasks');
    Route::get('/task_timeline/{id}', '\App\Http\Controllers\PMU\PmuController@task_timeline') -> name('pmu.task_timeline');
    Route::get('/assign_approval_staff/{task_id}/{staff_id}', '\App\Http\Controllers\PMU\PmuController@assign_approval_staff') -> name('pmu.assign_approval_staff');
    Route::get('/cancel_approval/{id}', '\App\Http\Controllers\PMU\PmuController@cancel_approval') -> name('pmu.cancel_approval');
    Route::get('/approve/{id}/{comment}', '\App\Http\Controllers\PMU\PmuController@approve') -> name('pmu.approve');
    Route::get('/require_doc/{id}', '\App\Http\Controllers\PMU\PmuController@require_doc') -> name('pmu.require_doc');
    Route::get('/cancel_doc/{id}', '\App\Http\Controllers\PMU\PmuController@cancel_doc') -> name('pmu.cancel_doc');
    Route::post('/upload_doc', '\App\Http\Controllers\PMU\PmuController@upload_doc') -> name('pmu.upload_doc');

    Route::resource('contracts', '\App\Http\Controllers\Procurements\ContractsController');
    Route::get('/contracts/timeline/{id}', '\App\Http\Controllers\Procurements\ContractsController@timeline')->name('contracts.timeline');
    Route::get('/contracts/link_task/{id}', '\App\Http\Controllers\Procurements\ContractsController@link_tasks')->name('contracts.link_tasks');
    Route::post('/contracts/upload_contract', '\App\Http\Controllers\Procurements\ContractsController@upload_contracts')->name('contracts.upload');
    Route::post('/contracts/upload_amendment', '\App\Http\Controllers\Procurements\ContractsController@upload_amendment')->name('amendment.upload');
    Route::post('/contracts/link_task', '\App\Http\Controllers\Procurements\ContractsController@link_task')->name('contracts.link_task');
    Route::get('/procurement/ongoing', '\App\Http\Controllers\Procurements\ProcurementController@ongoing_procurements')->name('procurements.ongoing');
    Route::get('/procurement/awarded', function () {return view('procurements.awarded');});
    Route::resource('procurement', '\App\Http\Controllers\Progress\ProgressController');
    Route::resource('variations', '\App\Http\Controllers\Procurements\VariationsController');
    Route::get('/variations/timeline/{id}', '\App\Http\Controllers\Procurements\VariationsController@variation_timeline')->name('variation.timeline');
    Route::get('/variations/create/{id}', '\App\Http\Controllers\Procurements\VariationsController@variation_create')->name('variation.create');
    Route::get('/selected/{id}', '\App\Http\Controllers\Procurements\ContractsController@selected');
    Route::post('/variation/reject', '\App\Http\Controllers\Procurements\VariationsController@reject')->name('variation.reject');
    Route::post('/variation/verify', '\App\Http\Controllers\Procurements\VariationsController@verify')->name('variation.verify');
    Route::post('/variation/approve', '\App\Http\Controllers\Procurements\VariationsController@approve')->name('variation.approve');
    Route::post('/variation/authorize_variation', '\App\Http\Controllers\Procurements\VariationsController@authorize_variation')->name('variation.authorize_variation');
    Route::post("task_link_budget", '\App\Http\Controllers\Procurements\ContractsController@task_link_budget');

    Route::resource('progress', '\App\Http\Controllers\Progress\ProgressController');
    Route::get('live_progress', '\App\Http\Controllers\Progress\ProgressController@live_progress')->name('live.progress');




});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/gantt', function () {return view('gantt.gantt');});
    Route::get('/gantt/w', function () {return view('gantt.gantt_month');});
    Route::get('/gantt/m', function () {return view('gantt.gantt_month');});
    Route::get('/gantt/y', function () {return view('gantt.gantt_year');});
    Route::resource('profile', '\App\Http\Controllers\Auth\ProfileController');
    Route::post('/profile_pic', '\App\Http\Controllers\Auth\ProfileController@upload_profile_pic') -> name('profile.upload_pic');
    Route::post('/update_profile', '\App\Http\Controllers\Auth\ProfileController@update_profile') -> name('profile.update');

    Route::get('/resultframework/pdo', function () {return view('resultframework.pdo');});
    Route::get('/resultframework/intermediate', function () {return view('resultframework.intermediate');});
    Route::get('/resultframework/dli', function () {return view('resultframework.dli');});

    Route::get('/dashboard/home', 'DashboardController@versionone')->name('home');
    Route::get('/dashboard/livefeed', 'DashboardController@livefeed')->name('livefeed');
    Route::get('/dashboard/v2', 'DashboardController@versiontwo')->name('v2');
    Route::get('/dashboard/v3', 'DashboardController@versionthree')->name('v3');
    Route::get('/critical', 'DashboardController@critical')->name('critical');



});


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/phpinfo', function () {return view('phpinfo');});
Route::get('/welcome','HomeController@welcome')->name('mail.user.welcome');

Route::get('/test/{task_id}/{staff_id}', 'PMU\PmuController@assign_staff');

Auth::routes();
