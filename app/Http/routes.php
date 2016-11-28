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
Route::group(['middleware' => ['auth', 'admin', 'activeUser']], function () {
	// Home Page
	Route::get('admin', 'Admin\UserController@index');

	// Galeri Kategori
	Route::get('admin/galeri/kategori', 'Admin\GalleryCategoryController@index');
	Route::get('admin/galeri/kategori/getdata', 'Admin\GalleryCategoryController@indexData');
	// Add Gallery Category Name
	Route::post('admin/galeri/kategori/add', 'Admin\GalleryCategoryController@addPost');
	// Edit Gallery Item
	Route::get('admin/galeri/kategori/edit/{id}', 'Admin\GalleryCategoryController@edit');
	// Edit Gallery Category Name
	Route::post('admin/galeri/kategori/edit', 'Admin\GalleryCategoryController@editPost');
	// Delete Gallery Category & All Gallery Items
	Route::post('admin/galeri/kategori/delete', 'Admin\GalleryCategoryController@deletePost');
	// Gallery Image Upload
	Route::post('upload', ['as' => 'upload-post', 'uses' =>'Admin\ImageController@postUpload']);
	Route::post('upload/delete', ['as' => 'upload-remove', 'uses' =>'Admin\ImageController@deleteUpload']);

	// File Upload
	Route::get('admin/file/', 'Admin\FileController@index');
	Route::get('admin/file/getdata', 'Admin\FileController@indexData');
	// Add
	Route::get('admin/file/add', 'Admin\FileController@add');
	Route::post('admin/file/add', 'Admin\FileController@addPost');
	// Delete
	Route::post('admin/file/delete', 'Admin\FileController@deletePost');
	// Edit Name
	Route::post('admin/file/edit', 'Admin\FileController@editPost');

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

	// Kelola Kategori Artikel
	Route::get('admin/artikel/kategori', 'Admin\ArticleCategoryController@index');
	Route::get('admin/artikel/kategori/getdata', 'Admin\ArticleCategoryController@indexData');
	// Add
	Route::get('admin/artikel/kategori/add', 'Admin\ArticleCategoryController@add');
	Route::post('admin/artikel/kategori/add', 'Admin\ArticleCategoryController@addPost');
	// Edit
	Route::get('admin/artikel/kategori/edit/{id}', 'Admin\ArticleCategoryController@edit');
	Route::post('admin/artikel/kategori/edit', 'Admin\ArticleCategoryController@editPost');
	// Delete
	Route::post('admin/artikel/kategori/delete', 'Admin\ArticleCategoryController@deletePost');

	// Kelola Artikel
	Route::get('admin/kelola/artikel', 'Admin\ArticleController@index');
	Route::get('admin/kelola/artikel/getdata', 'Admin\ArticleController@indexData');
	// Non Aktif
	Route::get('admin/kelola/artikel/nonaktif', 'Admin\ArticleController@indexNonAktif');
	Route::get('admin/kelola/artikel/nonaktif/getdata', 'Admin\ArticleController@indexNonAktifData');
	// Add
	Route::get('admin/kelola/artikel/add', 'Admin\ArticleController@add');
	Route::post('admin/kelola/artikel/add', 'Admin\ArticleController@addPost');
	// Edit
	Route::get('admin/kelola/artikel/edit/{id}', 'Admin\ArticleController@edit');
	Route::post('admin/kelola/artikel/edit', 'Admin\ArticleController@editPost');
	// Delete
	Route::post('admin/kelola/artikel/delete', 'Admin\ArticleController@deletePost');

	// Kustom Halaman
	Route::get('admin/halaman', 'Admin\PageController@index');
	Route::get('admin/halaman/getdata', 'Admin\PageController@indexData');
	// Add
	Route::get('admin/halaman/add', 'Admin\PageController@add');
	Route::post('admin/halaman/add', 'Admin\PageController@addPost');
	// Edit
	Route::get('admin/halaman/edit/{id}', 'Admin\PageController@edit');
	Route::post('admin/halaman/edit', 'Admin\PageController@editPost');
	// Delete
	Route::post('admin/halaman/delete', 'Admin\PageController@deletePost');
});

Route::auth();
// Route::get('/home', 'HomeController@index');
