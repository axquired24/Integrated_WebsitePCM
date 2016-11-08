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

Route::get('/', function () {
    return view('pcm.home');
});

Route::get('sekolah', function() {
	return view('sekolah.home');
});

Route::get('admin', function() {
	return view('layouts.admin');
});

Route::auth();

Route::get('/home', 'HomeController@index');
