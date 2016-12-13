<?php
namespace App\Logic\PCM;

// DB Models
use App\Models\Menu;
use App\Models\Page;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\File as FileUpload;
// Package
use Share;
// use File;

/**
* Article Repository
*/
class DefaultRepository
{
	// Ambil Daftar Menu Navbar
	public function getMenus($aum_id)
	{
		$menus 	= Menu::where('aum_list_id', $aum_id)->get();
		return $menus;
	}

	// Ambil Kategori = 'Pengumuman' dalam AUM terpilih
	public function getPengumumanKategori($aum_id)
	{
		$kategori_pengumuman 		= ArticleCategory::where([
	    								['aum_list_id', $aum_id],
	    								['name', 'Pengumuman']
	    								])->first();
		return $kategori_pengumuman;
	}

	// Ambil Konten Pengumuman yang aktif
	public function getPengumumans($aum_id, $take=4)
	{
		$kategori_pengumuman 		= $this->getPengumumanKategori($aum_id);
		$pengumumans 				= Article::where([
										['article_category_id', $kategori_pengumuman->id],
										['is_active', 1]
										])
										->orderBy('id', 'DESC')
										->skip(0)
										->take($take)
										->get();
		return $pengumumans;
	}

	// Paginate pengumuman next & previous
	public function getAjaxPengumumans($aum_id, $page)
	{
		$take 						= 4;
		$skip 						= ($page - 1) * $take;
		$kategori_pengumuman 		= $this->getPengumumanKategori($aum_id);
		$pengumumans 				= Article::where([
										['article_category_id', $kategori_pengumuman->id],
										['is_active', 1]
										])
										->orderBy('id', 'DESC')
										->skip($skip)
										->take($take)
										->get();
		return $pengumumans;
	}

	public function ajaxPengumumanTotalPage($aum_id)
	{
		$take 						= 4;
		$kategori_pengumuman 		= $this->getPengumumanKategori($aum_id);
		$count_pengumuman			= Article::where([
										['article_category_id', $kategori_pengumuman->id],
										['is_active', 1]
										])
										->count();
		$pengumuman 				= ceil($count_pengumuman / $take);
		return $pengumuman;
	}

	// Ambil Kategori != 'Pengumuman'
	public function getNonPengumumanKategoris($aum_id)
	{
		$non_pengumuman_kategoris	= ArticleCategory::where([
	    								['aum_list_id', $aum_id],
	    								['name', '!=', 'Pengumuman'],
	    								])->get();
		return $non_pengumuman_kategoris;
	}

	// Kategori != 'Pengumuman' dalam AUM terpilih ->to Array
	public function arrayNonPengumumanKategoris($aum_id)
	{
		$non_pengumuman_kategoris 	= $this->getNonPengumumanKategoris($aum_id);
		$non_pengumuman_kategori 	= array();
    	foreach ($non_pengumuman_kategoris as $value) {
    		array_push($non_pengumuman_kategori, $value->id);
    	}

    	return 	$non_pengumuman_kategori;
	}

	// Ambil Konten Berita biasa (bukan Pengumuman) yang aktif
	public function getBeritas($aum_id, $limit=6)
	{
		$non_pengumuman_kategori 	= $this->arrayNonPengumumanKategoris($aum_id);
    	$beritas 					= Article::where('is_active', 1)
    									->whereIn('article_category_id', $non_pengumuman_kategori)
    									->orderBy('id', 'DESC')
										->paginate($limit);
		return $beritas;
	}

	// Ambil detail kategori
	public function getArtikelKategoriDetail($id)
	{
		return ArticleCategory::find($id);
	}

	// Ambil Berita Terkait untuk footer
	public function getRelatedBeritas($aum_id, $article_id, $take=4)
	{
		$non_pengumuman_kategori 	= $this->arrayNonPengumumanKategoris($aum_id);
    	$beritas 					= Article::where([
    											['is_active', 1],
    											['id', '!=', $article_id],
    											])
    									->whereIn('article_category_id', $non_pengumuman_kategori)
    									->inRandomOrder()
										->take($take)
										->get();
		return $beritas;
	}

	// Ambil Artikel berdasarkan kategori
	public function getArtikelDariKategoris($article_category_id, $paginate=6)
	{
		if($paginate 	== 'all')
		{
			$artikels 					= Article::where('is_active', 1)
    									->where('article_category_id', $article_category_id)
    									->orderBy('id', 'DESC')
										->get();
			return $artikels;
		}
		// else
		$artikels 					= Article::where('is_active', 1)
    									->where('article_category_id', $article_category_id)
    									->orderBy('id', 'DESC')
										->paginate($paginate);
		return $artikels;
	}

	// Ambil Detail Kategori
	public function getDetailGaleriKategori($id)
	{
		$galeri_kategori 	= GalleryCategory::find($id);
		return $galeri_kategori;
	}

	// Ambil Kategori Galeri Foto
	public function getGaleriKategoris($aum_id)
	{
		$galeri_kategoris			= GalleryCategory::where('aum_list_id', $aum_id)->get();
		return $galeri_kategoris;
	}

	public function arrayGaleriKategori($aum_id)
	{
		$galeri_kategoris 			= $this->getGaleriKategoris($aum_id);
		$galeri_kategori 			= array();
		foreach ($galeri_kategoris as $value) {
			array_push($galeri_kategori, $value->id);
		}

		return $galeri_kategori;
	}

	// Ambil Semua milik AUM terpilih (Ambil 4 Random - u/ Preview)
	public function getGaleris($aum_id)
	{
		$galeri_kategori 			= $this->arrayGaleriKategori($aum_id);
		$galeris 					= Gallery::whereIn('gallery_category_id', $galeri_kategori)
										->inRandomOrder()
										->take(4)
										->get();
		return 	$galeris;
	}

	// Get Galleries Desc Per Category
	public function getGaleriInKategoris($category_id, $paginate=6)
	{
		$galeris 					= Gallery::where('gallery_category_id', $category_id)
										->orderBy('id', 'DESC')
										->paginate($paginate);
		return 	$galeris;
	}

	// Ambil Random Preview Galeri Foto AUM Terpilih (ambil 1)
	public function getRandomGaleri($aum_id)
	{
		$galeri_kategori 			= $this->arrayGaleriKategori($aum_id);
		$random_galeri 				= Gallery::whereIn('gallery_category_id', $galeri_kategori)
												->inRandomOrder()
												->first();
		return $random_galeri;
	}

	public function share($currentUrl, $currentTitle)
	{
		$shares			= array();
    	array_push($shares, array('name' => 'Facebook' ,'link' => Share::load($currentUrl, $currentTitle)->facebook(), 'fa' => 'fa-facebook-square', 'ot' => 'www.facebook.com'));
    	array_push($shares, array('name' => 'Twitter' ,'link' => Share::load($currentUrl, $currentTitle)->twitter(), 'fa' => 'fa-twitter', 'ot' => 'www.twitter.com'));
    	array_push($shares, array('name' => 'Google+' ,'link' => Share::load($currentUrl, $currentTitle)->gplus(), 'fa' => 'fa-google-plus-square', 'ot' => 'plus.google.com'));
    	array_push($shares, array('name' => 'Whatsapp' ,'link' => 'whatsapp://send?text='.$currentUrl, 'fa' => 'fa-phone-square', 'ot' => 'Aplikasi Mobile'));
    	array_push($shares, array('name' => 'BBM' ,'link' => 'bbmi://api/share?message='.$currentUrl, 'fa' => 'fa-comments', 'ot' => 'Aplikasi Mobile'));
    	array_push($shares, array('name' => 'Copy URL' ,'link' => 'javascript:prompt("Copy alamat dibawah ini (Ctrl+C) Lalu pilih cancel", "'.$currentUrl.'")', 'fa' => 'fa-copy', 'ot' => 'Bagikan Manual'));

    	return $shares;
	}

	public function getFileLists($aum_id, $paginate=10)
	{
		$files 	= FileUpload::where('aum_list_id', $aum_id)
							->orderBy('id', 'DESC')
							->paginate($paginate);
		return $files;
	}

	public function downloadFile($id, $aum_id)
	{
		$fileGet 	= FileUpload::find($id);
		$filename	= $fileGet->filename;
		$pathToFile = public_path('files'.DIRECTORY_SEPARATOR.'lain'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR.$filename);
        return response()->download($pathToFile);
	}

	// For AUM ONLY ------------------------------------------------------------------------------------------------
	public function getAumProfilPage($aum_id)
	{
		$page 	= Page::where([
					['aum_list_id', $aum_id],
					['title', 'Profil'],
					])->first();
		return $page;
	}

	public function getArtikelAndDirect($aum_id, $paginate=8)
	{
		$kategori 	= $this->arrayNonPengumumanKategoris($aum_id);
		$beritas 	= Article::whereIn('article_category_id', $kategori)
								->where('is_active', '1')
								->orWhere(function($query) {
									$query->where('tag', 'direct');
								})
								->orderBy('id', 'DESC')
								->paginate($paginate);
		return $beritas;
	}

}