<?php

namespace App\Http\Controllers\PCM;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// DB Models
use App\Models\AumList;
use App\Models\Article;
use App\Models\Page;
// Repository
use App\Logic\PCM\DefaultRepository;

class DefaultController extends Controller
{
	public function __construct(Aumlist $aum_list, DefaultRepository $defaultRepository)
	{
		// Ambil Detail AUM & Inisialisasi DefaultRepository
		$this->aum 	= $aum_list::find('1');
		$this->def 	= $defaultRepository;
	}

    public function index()
    {
		// Return View & Bye pass semua variable
    	return view('pcm.home', [
    			'aum' 			=> $this->aum,
    			'menus' 		=> $this->def->getMenus($this->aum->id),
    			'pengumumans' 	=> $this->def->getPengumumans($this->aum->id),
    			'beritas' 		=> $this->def->getBeritas($this->aum->id),
    			'galeris' 		=> $this->def->getGaleris($this->aum->id),

    			'random_galeri' 			=> $this->def->getRandomGaleri($this->aum->id),
    			'kategori_pengumuman' 		=> $this->def->getPengumumanKategori($this->aum->id),
    			'non_pengumuman_kategoris' 	=> $this->def->getNonPengumumanKategoris($this->aum->id),
    			// Pengumuman total page @pagination
    			'total_pengumuman' 			=> $this->def->ajaxPengumumanTotalPage($this->aum->id),
    		]);
    }

    public function artikelKategori($article_category_id)
    {
    	return view('pcm.artikelkategori', [
    			'aum' 			=> $this->aum,
    			'kategori' 		=> $this->def->getArtikelKategoriDetail($article_category_id),
    			'beritas'		=> $this->def->getArtikelDariKategoris($article_category_id),
    			'menus' 		=> $this->def->getMenus($this->aum->id),
    			'pengumumans' 	=> $this->def->getPengumumans($this->aum->id),

    			'non_pengumuman_kategoris' 	=> $this->def->getNonPengumumanKategoris($this->aum->id),
    		]);
    }

    public function artikelDetail($id)
    {
    	$artikel 		= Article::find($id);
    	// Share Social Media
    	$currentUrl		= url('artikel/'.$artikel->id);
    	$currentTitle	= str_limit($artikel->title, 50);

    	return view('pcm.artikel', [
    			'aum' 			=> $this->aum,
    			'artikel'		=> $artikel,
    			'menus' 		=> $this->def->getMenus($this->aum->id),
    			'pengumumans' 	=> $this->def->getPengumumans($this->aum->id),
    			'shares' 		=> $this->def->share($currentUrl, $currentTitle),
                'relateds'      => $this->def->getRelatedBeritas($this->aum->id,$artikel->id,4),
    		]);
    }

    public function cariArtikel(Request $request)
    {
        $aum_id     = $request['aum_id'];
        $search     = $request['cari'];
        $take       = 5;
        $artikel    = $this->def->searchArticles($aum_id, $search, $take);
        return response()->json($artikel);
    }

    public function halamanDetail($id)
    {
    	$halaman 		= Page::find($id);
    	// Share Social Media
    	$currentUrl		= url('halaman/'.$halaman->id);
    	$currentTitle	= str_limit($halaman->title, 50);

    	return view('pcm.halaman', [
    			'aum' 			=> $this->aum,
    			'halaman'		=> $halaman,
    			'menus' 		=> $this->def->getMenus($this->aum->id),
    			'pengumumans' 	=> $this->def->getPengumumans($this->aum->id),
    			'beritas' 		=> $this->def->getBeritas($this->aum->id,4),
    			'shares' 		=> $this->def->share($currentUrl, $currentTitle),
    		]);
    }

    public function ajaxPengumuman(Request $request)
    {
    	$aum 			= $this->aum;
    	$next_page 		= $request['next_page'];
    	$current_page 	= $request['current_page'];
    	$get_pengumuman = $this->def->getAjaxPengumumans($this->aum->id, $next_page);
    	$str_return 	= '';
    	foreach($get_pengumuman as $pengumuman)
    	{
    			$str_return .= '
                <li class="media">
                  <a class="media-left" href="'.url('artikel/'.$pengumuman->id).'">
                    <img class="media-object" src="'.url('files/artikel/'.$aum->id.'/'.$pengumuman->image_path).'" width="128px" height="100px" alt="Gambar : '.$pengumuman->title.'">
                  </a>
                  <div class="media-body">
                    <h5 class="media-heading"><a class="card-link" href="'.url('artikel/'.$pengumuman->id).'">'.str_limit($pengumuman->title, 40).'</a></h5>
                    '. str_limit(strip_tags($pengumuman->content), 130) .'<br>
                    <span class="tag tag-danger">Pengumuman</span> &nbsp; <span class="text-muted">'.date_format($pengumuman->updated_at, 'd F Y').'</span>
                  </div>
                  <br>
                </li>';
       } // endforeach
       $str_return .= '<div align="center"><a id="prevPengumumanBtn" href="javascript:prevPengumuman()" class="btn btn-sm btn-primary"><span class="fa fa-chevron-left"></span> Selanjutnya</a> &nbsp; <a id="nextPengumumanBtn" href="javascript:nextPengumuman()" class="btn btn-sm btn-primary">Sebelumnya <span class="fa fa-chevron-right"></span></a></div>';

    	return $str_return;
    }

    public function galeri()
    {
        return view('pcm.galeri', [
                'galerikategoris'   => $this->def->getGaleriKategoris($this->aum->id),
                'menus'             => $this->def->getMenus($this->aum->id),
                'aum'               => $this->aum,
            ]);
    }

    public function galeriKategori($id)
    {
        $paginate   = 9;
        return view('pcm.galerikategori', [
                'galerikategori'    => $this->def->getDetailGaleriKategori($id),
                'galeris'           => $this->def->getGaleriInKategoris($id,$paginate),
                'menus'             => $this->def->getMenus($this->aum->id),
                'aum'               => $this->aum,
            ]);
    }

    public function daftarFile()
    {
        $paginate   = 10;
        return view('pcm.daftarfile', [
                'listfiles'   => $this->def->getFileLists($this->aum->id, $paginate),
                'menus'             => $this->def->getMenus($this->aum->id),
                'aum'               => $this->aum,
            ]);
    }

    public function downloadFile($id)
    {
        $pathToFile     = $this->def->downloadFile($id, $this->aum->id);
        return $pathToFile;
    }

}
