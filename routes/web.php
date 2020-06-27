<?php

use App\Role\UserRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

/*

	Routing convention: Route::resource('/path', 'Controller') if you have all routes below

	GET /projects (index)
	GET /projects/create (create)

	GET /projects/{1} (show)
	POST /projects (store)

	GET /projects/1/edit (edit)
	PATCH /projects/1 (update)
	DELETE /projects/1 (destroy)

*/

$adminUrl = config('app.admin_url');

Route::get('/', 'User\HomeController@home')->middleware('auth');
Route::get('/schedule/create', 'User\HomeController@create')->middleware('auth');
Route::post('/schedule/createPost', 'User\HomeController@createPost')->name('createPost');
Route::get('/booking-time-off/', 'User\HomeController@bookingTimeOff')->middleware('auth');
Route::post('/booking-time-off/createPost', 'User\HomeController@bookingCreatePost');

Route::prefix($adminUrl)->group(function () {

	Route::get('/list-employee', 'Admin\ListEmployeeController@index')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::get('/list-employee/{user}/show', 'Admin\ListEmployeeController@show')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::get('/list-employee/create/{id}','Admin\ListEmployeeController@create')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::post('/list-employee/create/{id}','Admin\ListEmployeeController@store')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::get('/list-employee/{user_id}/show/{id}/edit','Admin\ListEmployeeController@edit')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::patch('/list-employee/{id}','Admin\ListEmployeeController@update')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::delete('/list-employee/{user_id}/show/{id}','Admin\ListEmployeeController@destroy')->middleware('check.user.role:' . UserRole::MANAGEMENT);

	Route::resource('/work-off', 'Admin\WorkOffController')->middleware('check.user.role:' . UserRole::MANAGEMENT);



	// Route cho quan ly lich lam viec Admin----------
	Route::get('/work-schedule', 'Admin\WorkScheduleController@index')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::get('/work-schedule/{user}/create', 'Admin\WorkScheduleController@create')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::post('/work-schedule/{user}', 'Admin\WorkScheduleController@store')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	
	Route::get('/work-schedule/{user}/edit', 'Admin\WorkScheduleController@edit')->middleware('check.user.role:' . UserRole::MANAGEMENT);

	Route::patch('/work-schedule/{user}', 'Admin\WorkScheduleController@update')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	Route::delete('/work-schedule/{user}', 'Admin\WorkScheduleController@destroy')->middleware('check.user.role:' . UserRole::MANAGEMENT);
	// close Route cho quan ly lich lam viec Admin-----------

	Route::get('', 'Admin\HomeController@index')->name('admin')->middleware('check.user.role:' . UserRole::SUPPORT);
	Route::get('/account', 'Admin\UserController@editCurrentAccount')->middleware('check.user.role:' . UserRole::SUPPORT);
	Route::resource('/template-exports', 'Admin\TemplateExportController')->middleware('check.user.role:' . UserRole::SUPPORT);
	Route::resource('/template', "Admin\TemplateController")->middleware('check.user.role:' . UserRole::SUPPORT);
	Route::patch('/account/update', 'Admin\UserController@updateCurrentAccount')->middleware('check.user.role:' . UserRole::SUPPORT);
	Route::get('/admin', function ($id) {
		return view(admin / createtime);
	});

	Route::resource('/work-schedule', 'Admin\WorkScheduleController')->middleware('check.user.role:' . UserRole::MANAGEMENT);	//resources route cho phan quan ly lich lam viec
	Route::post('/postWorkSchedule', 'Admin\WorkScheduleController@postWorkSchedule')->name('postWorkSchedule');

	Route::resource('/users', 'Admin\UserController')->middleware('check.user.role:' . UserRole::ADMIN); //Nhat
	Route::resource('/settings', 'Admin\SettingController')->middleware('check.user.role:' . UserRole::MANAGEMENT);

	Route::get('/templates', "Admin\UserController@templates");
	Route::get('/templates-detail/{id}', "Admin\UserController@templatesDetail");

	Route::post("/export", "Admin\UserController@export")->name("export");
	Route::post('workoffPost', 'Admin\WorkOffController@workoffPost')->name('workoffPost');
});
Route::get('/api/work-statistics', 'Api\WorkStatisticsController@apiWorkStatistics');

Auth::routes();