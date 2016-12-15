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
// Test Route
// Route::get('testRoute', function() {
// 	$fruits 	= 'http://localhost/sub-web-pemilik/mangga/apel/subekor/ekor';
// 	$exfruit 	= explode('/', $fruits);
// 	$ekor 		= end($exfruit);
// 	$subekor 	= prev($exfruit);
// 	$apel 		= prev($exfruit);
// 	return $apel;
// });

// Rute PCM
// Index
Route::get('/', 'PCM\DefaultController@index');
// Kategori Artikel
Route::get('artikelkategori/{article_category_id}', 'PCM\DefaultController@artikelKategori');
// detail artikel
Route::get('artikel/{id}', 'PCM\DefaultController@artikelDetail');
// Detail Halaman
Route::get('halaman/{id}', 'PCM\DefaultController@halamanDetail');
// Daftar Galeri
Route::get('galeri', 'PCM\DefaultController@galeri');
// Galeri Per Kategori
Route::get('galerikategori/{id}', 'PCM\DefaultController@galeriKategori');
// Daftar File Download
Route::get('daftarfile', 'PCM\DefaultController@daftarFile');
// Download Single File
Route::get('file/download/{id}', 'PCM\DefaultController@downloadFile');
// Ajax Next Prev Pengumuman
Route::post('artikel/ajax/nextpengumuman', 'PCM\DefaultController@ajaxPengumuman');
Route::post('artikel/ajax/cari', 'PCM\DefaultController@cariArtikel');

// EOF Rute PCM 	----------------------------------------------------------------------------------------------------------------------

// Rute Sub situs
Route::get('aum/{aum_seo_name}', 'AUM\AUMController@index');
Route::get('aum/{aum_seo_name}/home', 'AUM\AUMController@index');
// Kategori Artikel
Route::get('aum/{aum_seo_name}/artikelkategori/{article_category_id}', 'AUM\AUMController@artikelKategori');
// detail artikel
Route::get('aum/{aum_seo_name}/artikel/{id}', 'AUM\AUMController@artikelDetail');
// Detail Halaman
Route::get('aum/{aum_seo_name}/halaman/{id}', 'AUM\AUMController@halamanDetail');
// Daftar Galeri
Route::get('aum/{aum_seo_name}/galeri', 'AUM\AUMController@galeri');
// Galeri Per Kategori
Route::get('aum/{aum_seo_name}/galerikategori/{id}', 'AUM\AUMController@galeriKategori');
// Daftar File Download
Route::get('aum/{aum_seo_name}/daftarfile', 'AUM\AUMController@daftarFile');
// Download Single File
Route::get('aum/{aum_seo_name}/file/download/{id}', 'AUM\AUMController@downloadFile');
Route::post('aum/{aum_seo_name}/artikel/ajax/cari', 'AUM\AUMController@cariArtikel');

// EOF Rute Subsitus 	----------------------------------------------------------------------------------------------------------------------

// Rute Kontributor 
Route::group(['middleware' => ['auth', 'activeUser']], function () {
	// Sudah Terbit
	Route::get('admin', 'Admin\ArticleController@index');
	Route::get('admin/kelola/artikelKontributor/getdata', 'KontributorController@indexData');
	// Add
	Route::get('admin/kelola/artikelKontributor/add', 'KontributorController@add');
	Route::post('admin/kelola/artikelKontributor/add', 'KontributorController@addPost');
	// Get Article Category Ajax
	Route::post('admin/kelola/artikelKontributor/getArCategory', 'KontributorController@getArticleCategory');
	// Edit
	Route::get('admin/kelola/artikelKontributor/edit/{id}', 'KontributorController@edit');
	Route::post('admin/kelola/artikelKontributor/edit', 'KontributorController@editPost');
	// Delete
	Route::post('admin/kelola/artikelKontributor/delete', 'KontributorController@deletePost');

	// Kelola Pengguna
	// Edit
	Route::get('admin/kelola/pengguna/edit/{id}', 'Admin\UserController@edit');
	Route::post('admin/kelola/pengguna/edit', 'Admin\UserController@editPost');
});

// EOF Rute Kontibutor 	----------------------------------------------------------------------------------------------------------------------

// Rute Staff Page
Route::group(['middleware' => ['auth', 'staff', 'activeUser']], function () {
	// Home Page
	// Route::get('admin', 'Admin\ArticleController@index');

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
	// Pengumuman
	Route::get('admin/kelola/artikel/pengumuman', 'Admin\ArticleController@indexPengumuman');
	Route::get('admin/kelola/artikel/pengumuman/getdata', 'Admin\ArticleController@indexPengumumanData');
	// Artikel Broadcast
	Route::get('admin/kelola/castartikel', 'Admin\ArticleController@indexCast');
	Route::get('admin/kelola/castartikel/getdata', 'Admin\ArticleController@indexCastData');
	// Add
	Route::get('admin/kelola/artikel/add/{kat?}', 'Admin\ArticleController@add');
	Route::post('admin/kelola/artikel/add', 'Admin\ArticleController@addPost');
	// Edit
	Route::get('admin/kelola/artikel/edit/{id}/{pengumuman?}', 'Admin\ArticleController@edit');
	Route::post('admin/kelola/artikel/edit', 'Admin\ArticleController@editPost');
	// Delete
	Route::post('admin/kelola/artikel/delete', 'Admin\ArticleController@deletePost');
	// Set & Unset BroadCast
	Route::post('admin/kelola/artikel/setCast', 'Admin\ArticleController@setCast');
	Route::post('admin/kelola/artikel/unsetCast', 'Admin\ArticleController@unsetCast');

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

	// Galeri Kategori & Galeri Items upload
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

	// Kelola Menu
	Route::get('admin/menu/dtable', 'Admin\MenuController@index');
	Route::get('admin/menu/getdata', 'Admin\MenuController@indexData');
	// Add
	Route::get('admin/menu/add', 'Admin\MenuController@add');
	Route::post('admin/menu/add', 'Admin\MenuController@addPost');
	// Edit
	Route::get('admin/menu/edit/{id}', 'Admin\MenuController@edit');
	Route::post('admin/menu/edit', 'Admin\MenuController@editPost');
	// Delete
	Route::get('admin/menu/delete/{id}', 'Admin\MenuController@delete');
	// Arrange Order
	Route::get('admin/menu', 'Admin\MenuController@editOrder');
	Route::get('admin/menu/editOrder', 'Admin\MenuController@editOrder');
	Route::post('admin/menu/editOrder', 'Admin\MenuController@editOrderPost');

	// Kelola AUM
	Route::get('admin/kelola/aum/editSelf/{id}', 'Admin\AumListController@editSelf');
	Route::post('admin/kelola/aum/edit', 'Admin\AumListController@editPost');
	// Set Header
	Route::get('admin/kelola/aum/setheader', 'Admin\AumListController@setheader');
	Route::post('admin/kelola/aum/setheader', 'Admin\AumListController@setheaderPost');	

	// Kelola Pengguna
	// Edit
	// @ Kontributor Route
	//
});
// EOF Rute Staff 	----------------------------------------------------------------------------------------------------------------------

// Rute Admin Page
Route::group(['middleware' => ['auth', 'admin', 'activeUser']], function () {	
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
	// @ Staff Route
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
	// Route::post @ Staff Route
	// Delete
	Route::post('admin/kelola/aum/delete', 'Admin\AumListController@deletePost');
	// Set Header
	// @ Staff Route
});

Route::auth();
// Route::get('/home', 'HomeController@index');
