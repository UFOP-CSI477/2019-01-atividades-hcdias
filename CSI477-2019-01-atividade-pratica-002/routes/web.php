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
    return view('welcome');
})->name('welcome')->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {

	Route::get('procedures', [
		'as'=>'procedures.index',
		'uses'=>'ProcedureController@index'
	]);

	Route::get('procedures/create', [
		'as'=>'procedures.create',
		'uses'=>'ProcedureController@create'
	]);

	Route::post('procedures', [
		'as'=>'procedures.store',
		'uses'=>'ProcedureController@store'
	]);

	Route::get('procedures/{procedure}/edit', [
		'as'=>'procedures.edit',
		'uses'=>'ProcedureController@edit'
	]);

	Route::put('procedures/{procedure}',[
		'as'=>'procedures.update',
		'uses'=>'ProcedureController@update'
	]);

	Route::delete('procedures/{procedure}',[
		'as'=>'procedures.destroy',
		'uses'=>'ProcedureController@destroy'
	]);

	Route::get('tests', function () {
		return view('tests.index');
	})->name('tests');

	Route::get('tests/create', function () {
		return view('tests.create');
	})->name('tests.create');	

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

