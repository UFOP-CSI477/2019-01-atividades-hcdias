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

	Route::get('procedures', function () {
		return view('procedures.index');
	})->name('procedures');

	Route::get('procedures/create', function () {
		return view('procedures.create');
	})->name('procedures.create');	

	Route::get('procedures/edit', function () {
		return view('procedures.edit');
	})->name('procedures.edit');	

	Route::get('tests', function () {
		return view('tests.index');
	})->name('tests');

	Route::get('tests/create', function () {
		return view('tests.create');
	})->name('tests.create');	

	Route::get('procedures/edit', function () {
		return view('procedures.edit');
	})->name('procedures.edit');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

