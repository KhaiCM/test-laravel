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

Route::get('/', 'IndexController@index');

Route::group(['prefix' => 'admin'], function () {

	Route::resource('setting', 'SettingController');
	Route::resource('social', 'SocialController');
	Route::resource('menu', 'MenuController');
	Route::resource('slide', 'SlideController');
	Route::resource('users', 'UserController');
	Route::resource('roles', 'RoleController');
	Route::post('role/set-role/{user}', 'RoleController@setRole')->name('role.set_role');
	Route::get('permission', 'RoleController@getIndex')->name('permission.index');
	Route::get('permission/create', 'RoleController@createPermission')->name('permission.create');
	Route::post('permission/store', 'RoleController@storePermission')->name('permission.store');
	Route::post('permission/set-permission', 'RoleController@setPermission')->name('permission.set_permission');

	Route::get('queue', 'QueueController@queueMail')->name('email.queue');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// , 'middleware' => 'admin.login'
Route::get('js_basic', 'HomeController@javascript');
