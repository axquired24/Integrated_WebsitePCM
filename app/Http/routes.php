<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Rute PCM
Route::get('/', function () {
    return view('pcm.home');
});

// Rute Sub situs
Route::get('sekolah', function() {
	return view('sekolah.home');
});

// Rute Admin Page
Route::group(['middleware' => 'auth'], function () {
	// Home Page
	Route::get('admin', 'Admin\UserController@index');

	// Kelola Pengguna
	Route::get('admin/kelola/pengguna', 'Admin\UserController@index');
	Route::get('admin/kelola/pengguna/getdata', 'Admin\UserController@indexData');
	// Pengguna Non Aktif
	Route::get('admin/kelola/pengguna/nonaktif', 'Admin\UserController@indexNonAktif');
	Route::get('admin/kelola/pengguna/nonaktif/getdata', 'Admin\UserController@indexDataNonAktif');

	// Detail Pengguna
	Route::post('admin/kelola/pengguna/detail', 'Admin\UserController@detailData');
	// Add
	Route::get('admin/kelola/pengguna/add', 'Admin\UserController@add');
	Route::post('admin/kelola/pengguna/add', 'Admin\UserController@addPost');
	// Edit
	Route::get('admin/kelola/pengguna/edit/{id}', 'Admin\UserController@edit');
	Route::post('admin/kelola/pengguna/edit', 'Admin\UserController@editPost');
	// Delete
	Route::post('admin/kelola/pengguna/delete', 'Admin\UserController@deletePost');

	// Kelola AUM
	Route::get('admin/kelola/aum', 'Admin\AumListController@index');
	Route::get('admin/kelola/aum/getdata', 'Admin\AumListController@indexData');
	// Detail
	Route::get('admin/kelola/aum/detail/{id}', 'Admin\AumListController@detail');
	// Add
	Route::get('admin/kelola/aum/add', 'Admin\AumListController@add');
	Route::post('admin/kelola/aum/add', 'Admin\AumListController@addPost');
	// Edit
	Route::get('admin/kelola/aum/edit/{id}', 'Admin\AumListController@edit');
	Route::post('admin/kelola/aum/edit', 'Admin\AumListController@editPost');
	// Delete
	Route::post('admin/kelola/aum/delete', 'Admin\AumListController@deletePost');


});

Route::auth();

Route::get('/home', 'HomeController@index');
