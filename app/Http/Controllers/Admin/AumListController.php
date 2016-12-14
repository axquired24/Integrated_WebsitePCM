<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Datatables;
use DB;
use Redirect;

use Illuminate\Support\Facades\File as File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\AumList;
use App\Models\ArticleCategory;
use App\Models\Article;
use App\Models\File as FileUpload;
use App\Models\GalleryCategory;
use App\Models\Page;
use App\Models\Menu;
// Use Other Controller
// use MenuController as MenuRepository;

class AumListController extends MenuController
{

    public function index()
    {
    	return view('admin.aum_list.list');
    }

    public function indexData(Request $request)
    {
		// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= AumList::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'aum_lists.*',
					// Or Select all with table.*
					]);
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
	    		->addColumn('action', function($table){
	    			return
	    			'<a title="hapus" href="#" onclick="deleteBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="ubah" href="'.url('admin/kelola/aum/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
	    				<a title="detail" href="'.url('admin/kelola/aum/detail/'.$table->id).'" class="btn btn-sm btn-secondary"><span class="fa fa-file-text-o"></span></a>';
	    		})
	    		->make(true);
    }

    public function detail($id)
    {
    	$aum 	= AumList::find($id);
    	return view('admin.aum_list.detail', ['aum' => $aum]);
    }

    public function add()
    {
    	return view('admin.aum_list.add');
    }

    public function addPost(Request $request)
    {
    	$this->validate($request, [
	        'name' => 'unique:aum_lists',
	    ]);

	    $aum 	= new AumList();

	    $aum->name 	= $request['name'];
	    $aum->address 	= $request['address'];
	    $aum->gmap_lat 	= $request['gmap_lat'];
	    $aum->gmap_lng 	= $request['gmap_lng'];
	    $aum->contact 	= $request['contact'];
	    $aum->seo_name 	= str_slug($request['name'], '-');
	    $aum->save();

        // Add Category Pengumuman & Berita
        $ac1    = new ArticleCategory();
        $ac1->name  = 'Pengumuman';
        $ac1->aum_list_id  = $aum->id;
        $ac1->save();
        $ac2    = new ArticleCategory();
        $ac2->aum_list_id  = $aum->id;
        $ac2->name  = 'Berita';
        $ac2->save();

        // Add Kustom Halaman
        $page1  = new Page();
        $page1->title        = 'Profil';
        $page1->image_path   = '#';
        $page1->aum_list_id  = $aum->id;
        $page1->save();

        // Add Menu Navigation
        $menu1   = new Menu();
        $menu1->name    = 'Profil';
        $menu1->link    = url('aum/'.$aum->seo_name.'/halaman/'.$page1->id);
        $menu1->aum_list_id  = $aum->id;
        $menu1->save();
        //
        $menu2   = new Menu();
        $menu2->name    = 'Galeri';
        $menu2->link    = url('aum/'.$aum->seo_name.'/galeri');
        $menu2->aum_list_id  = $aum->id;
        $menu2->save();
        //
        $menu3   = new Menu();
        $menu3->name    = 'Download';
        $menu3->link    = url('aum/'.$aum->seo_name.'/daftarfile');
        $menu3->aum_list_id  = $aum->id;
        $menu3->save();

	    return Redirect::to('admin/kelola/aum');
    }

    public function edit($id)
    {
    	$aum 	= AumList::find($id);
    	return view('admin.aum_list.edit', ['aum' => $aum]);
    }

    // Edit AUM Self // Only Itself
    public function editSelf($id)
    {
        $user_aum_id    = Auth::user()->aum_list_id;
        $aum    = AumList::find($id);
        $self   = 'self';

        if($user_aum_id != $aum->id) {
            return Redirect::to('admin')->with('success', '<b>Error</b> Anda tidak memiliki hak akses untuk mengubah sub situs lain');
        }
        return view('admin.aum_list.edit', ['aum' => $aum], ['self' => $self]);
    }

    public function editPost(Request $request)
    {
    	$id 	= $request['id'];
    	$this->validate($request, [
	        'name' => 'unique:aum_lists,name,'.$id,
	        // 'name' => 'unique:aum_lists',
	    ]);

	    $aum 	= AumList::find($id);

	    $aum->name 	= $request['name'];
	    $aum->address 	= $request['address'];
	    $aum->gmap_lat 	= $request['gmap_lat'];
	    $aum->gmap_lng 	= $request['gmap_lng'];
	    $aum->contact 	= $request['contact'];
	    $aum->seo_name 	= str_slug($request['name'], '-');

	    $aum->save();

        // Update Menu Links from extends MenuController
        $this->refreshPageLink($aum->id);
        $this->refreshLink($aum->id);

        if(isset($request['self']))
        {
            return Redirect::to('admin/menu/dtable')->with('success', '<b>Hore!</b> Detail Situs berhasil diupdate');
        }
	    return Redirect::to('admin/kelola/aum');
    }

    public function deletePost(Request $request)
    {
    	$id 	= $request['id'];

    	// Cek
    	$user 		= User::where('aum_list_id', '=', $id)->first();
    	$file 		= FileUpload::where('aum_list_id', '=', $id)->first();
    	$page 		= Page::where([
                                    ['title', '!=', 'Profil'],
                                    ['aum_list_id', '=', $id],
                                    ])->first();
    	$articleCats= ArticleCategory::where('aum_list_id', '=', $id)->get();
        $articleCat = array();
        foreach ($articleCats as $cat) {
            array_push($articleCat, $cat->id);
        }
        $article    = Article::whereIn('article_category_id', $articleCat)->first();
    	$galleryCat = GalleryCategory::where('aum_list_id', '=', $id)->first();

    	if(isset($user->id)){
    		return 'Error. Masih ada pengguna dalam sub situs ini';
    	}
    	elseif(isset($file->id)){
    		return 'Error. Masih ada file dalam sub situs ini';
    	}
    	elseif(isset($page->id)){
    		return 'Error. Masih ada kustom halaman dalam sub situs ini';
    	}
    	elseif(isset($article->id)){
    		return 'Error. Masih ada artikel dalam sub situs ini';
    	}
    	elseif(isset($galleryCat->id)){
    		return 'Error. Masih ada galeri dalam sub situs ini';
    	}
    	else {
    		// Delete Safely
    		$aum 	= AumList::find($id);
    		// Delete Article Category
            foreach ($articleCats as $del) {
                $exedel = ArticleCategory::find($del->id);
                $delCat = $exedel->delete();
            }
            // Delete Menu
            $menus   = Menu::where('aum_list_id', $aum->id)->get();
            foreach ($menus as $del) {
                $exedel = Menu::find($del->id);
                $delCat = $exedel->delete();
            }
            $pages       = Page::where('aum_list_id', '=', $id)->get();
            foreach ($pages as $del) {
                $exedel = Page::find($del->id);
                $delCat = $exedel->delete();
            }
            // Delete Aum Information
            $del    = $aum->delete();
    		return 'Hapus berhasil';
    	} // Close if Cek
    }

    public function setheader()
    {
        $aum_id     = Auth::user()->aum_list_id;
        $aum        = AumList::find($aum_id);
        return view('admin.aum_list.setheader', ['aum' => $aum]);
    }

    public function setheaderPost(Request $request)
    {
        $id         = $request['id'];
        $aum        = AumList::find($id);

        if(isset($request['file']))
        {
            $rules     = [
                            'file' => 'required|mimes:png,gif,jpeg,jpg|max:8192',
                        ];

            $messages   = [
                            'file.mimes' => 'Ekstensi File Gambar tidak didukung. Require(png,jpg,jpeg)',
                            'file.required' => 'File Gambar bermasalah. Coba gambar lain/ kompres gambar dengan benar (Cek: Resolusi maksimal lebar&tinggi 2000pixel, file maksimal 8mb)',
                            'file.max' => 'File gambar maksimal 8 MB',
                        ];
            $validator = Validator::make($request->all(), $rules, $messages);

            // dd($validator);

            if ($validator->fails()) {

                return redirect('admin/kelola/aum/setheader')
                            ->with('aum', $aum)
                            ->withErrors($validator)
                            ->withInput();
            }
        } // if isset file

        // Logic Image Folder Create For Each Aum
        $aum_id     = $id;
        $path       = public_path('files'.DIRECTORY_SEPARATOR.'header'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        if (!File::exists($path)) {
            $makeDir = File::makeDirectory($path, 0777, true, true);
        } // EOF if

        if(isset($request['file']))
        {
            $oldPath            = $path;
            $oldOriPath         = $oldPath . $aum->header_path;
            $oldThumbPath       = $oldPath . 'thumb-' .$aum->header_path;

            // Image Processing New File
            $photo  = $request['file'];
            $extension = $photo->getClientOriginalExtension();
            $allowed_filename = "h" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
            $icon_name      = 'thumb-' . $allowed_filename;

            $uploadSuccess1 = $this->original( $photo, $allowed_filename, $path );
            $uploadSuccess2 = $this->icon( $photo, $icon_name, $path );

            $aum->header_path            = $allowed_filename;

            // Delete old file if exist | If new file success uploaded
            if (File::exists($oldOriPath)) {
                $del = File::delete($oldOriPath);
            }
            if (File::exists($oldThumbPath)) {
                $del = File::delete($oldThumbPath);
            }
        } // EOF if isset(file)

        $aum->save();
        return Redirect::to('admin/kelola/aum/setheader')
                            ->with('success', '<b>Hore!</b> Header Situs berhasil diperbarui');
    }

    // Image Processor
     /**
     * Optimize Original Image
     */
    public function original( $photo, $filename, $path )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(1366, null, function ($constraint) {
            $constraint->aspectRatio();
            })
            ->save( $path  . $filename );

        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename, $path )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
            })
            ->save( $path  . $filename );

        return $image;
    }

}
