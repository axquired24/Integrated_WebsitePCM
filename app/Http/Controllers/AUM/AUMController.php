<?php

namespace App\Http\Controllers\AUM;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// DB Models
use App\Models\AumList;
use App\Models\Article;
// use App\Models\Page;
// Repository
use App\Logic\PCM\DefaultRepository;
// Package
use Route;

class AUMController extends Controller
{
    public function __construct(Aumlist $aum_list, DefaultRepository $defaultRepository)
	{
		// Ambil Detail AUM & Inisialisasi DefaultRepository
		$this->aum_seo_name 	= Route::current()->getParameter('aum_seo_name');
		$this->aum 	= $aum_list::where('seo_name', $this->aum_seo_name)->firstOrFail(); // Auto Redirect if not found
		$this->def 	= $defaultRepository;
	}

	public function index()
	{
		$paginate 	= 7;
		$take 		= 3;
    	return view('aum.home', [
    			'aum' 			=> $this->aum,
    			'menus' 		=> $this->def->getMenus($this->aum->id),
    			'pengumumans' 	=> $this->def->getPengumumans($this->aum->id, $take),
    			'beritas' 		=> $this->def->getArtikelAndDirect($this->aum->id, $paginate),
    			'galeris' 		=> $this->def->getGaleris($this->aum->id),
    			'profilPage' 	=> $this->def->getAumProfilPage($this->aum->id),
    			'daftarFile' 	=> $this->def->getFileLists($this->aum->id, $take),

    			'random_galeri' 			=> $this->def->getRandomGaleri($this->aum->id),
    			'kategori_pengumuman' 		=> $this->def->getPengumumanKategori($this->aum->id),
    			'non_pengumuman_kategoris' 	=> $this->def->getNonPengumumanKategoris($this->aum->id),
    			// Pengumuman total page @pagination
    			'total_pengumuman' 			=> $this->def->ajaxPengumumanTotalPage($this->aum->id),
    		]);
	}

    public function artikelDetail($aum_seo_name, $id)
    {
    	$artikel 		= Article::find($id);
    	// Share Social Media
    	$currentUrl		= url('aum/'.$aum_seo_name.'artikel/'.$artikel->id);
    	$currentTitle	= str_limit($artikel->title, 50);

    	return view('aum.artikel', [
    			'aum' 			=> $this->aum,
    			'artikel'		=> $artikel,
    			'menus' 		=> $this->def->getMenus($this->aum->id),
    			'pengumumans' 	=> $this->def->getPengumumans($this->aum->id),
    			'shares' 		=> $this->def->share($currentUrl, $currentTitle),
    			'relateds'      => $this->def->getRelatedBeritas($this->aum->id,$artikel->id,4),
    		]);
    }

    public function downloadFile($aum_seo_name, $id)
    {
        $pathToFile     = $this->def->downloadFile($id, $this->aum->id);
        return $pathToFile;
    }

}
