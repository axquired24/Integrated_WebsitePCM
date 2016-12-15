<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Datatables;
use DB;
use Redirect;
// use Image;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;

// use App\User;
use App\Models\AumList;
use App\Models\Article;
use App\Models\ArticleCategory;

class KontributorController extends Controller
{
    public function indexData(Request $request)
    {
    	$user_id 	= Auth::user()->id;
		// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= Article::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'articles.id as id', 'articles.article_category_id as article_category_id', 'articles.title as title', 'articles.image_path as image_path','articles.is_active as is_active',  'article_categories.name as category_name', 'aum_lists.name as aum_name'
					// Or Select all with table.*
					])
                    ->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                    ->join('aum_lists', 'article_categories.aum_list_id', '=', 'aum_lists.id')
                    ->where([
                            // ['articles.is_active',1],
                            ['article_categories.name', '!=', 'Pengumuman'],
                            ['articles.user_id', '=', $user_id],
                            // ['articles.tag','!=','direct']
                            ])->get();
        // if(isset)
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
                ->editColumn('rownum', function($table) {
                    return $table->rownum . '<div class="hidden-sm-down"><img class="img-fluid" width="50px" src="'.url('files/artikel/'.$table->articleCategory->aum_list_id.'/thumb-'.$table->image_path).'" alt="Gambar '.$table->title.'"></div>';
                })
                ->editColumn('title', function($table) {
                    $curUrl = '';
                    $aum_id = $table->articleCategory->aum_list_id;
                    if($aum_id == '1') {
                    	$curUrl 	= url('artikel/'.$table->id);
                    } else {
                    	$aum_seo_name = $table->articleCategory->aumList->seo_name;
                    	$curUrl 	= url('aum/'.$aum_seo_name.'/artikel/'.$table->id);
                    }

                    $editUrl 	= url('admin/kelola/artikelKontributor/edit/'.$table->id);
                    $delAttr 	= $table->id . ',\''.$table->title.'\'';
                    return '<a class="card-link" title="Klik untuk preview" href="'.$curUrl.'" target="_blank">
                    		'.$table->title.'</a> <small>['.$table->articleCategory->name.']</small>
                    		<br>
                    		<a href="'.$editUrl.'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                    		<a href="javascript:deleteBtn('.$delAttr.')" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></a>
                    		';
                })
                ->editColumn('is_active', function($table) {
                	$status = array('<span class="text-danger">non-aktif</span>', 'aktif');
                	return '[<em>'.$status[$table->is_active].'</em>]';
                })
	    		->make(true);
    }

    public function add()
    {
    	$aumLists 	= AumList::where('id', '!=', '0')
    					->orderBy('name', 'ASC')
    					->get();
    	return view('admin.artikel_kontributor.add', [
    		'aumLists' => $aumLists
    		]);
    }

    public function addPost(Request $request)
    {
    	$aum_id 	= $request['aum_id'];
    	$rules 	   = [
        				'file' => 'required|mimes:png,gif,jpeg,jpg,bmp|max:8192',
        			];

    	$messages   = [
				        'file.mimes' => 'Ekstensi File Gambar tidak didukung. Require(png,jpg,jpeg)',
				        'file.required' => 'File Gambar bermasalah. Coba gambar lain/ kompres gambar dengan benar (Cek: Resolusi maksimal lebar&tinggi 2000pixel, file maksimal 8mb)',
				        'file.max' => 'File gambar maksimal 8 MB',
    				];
        $validator = Validator::make($request->all(), $rules, $messages);

        // dd($validator);

        if ($validator->fails()) {

			return redirect('admin/kelola/artikel/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Logic Image Folder Create For Each Aum
    	$path 	= public_path('files'.DIRECTORY_SEPARATOR.'artikel'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
		if (!File::exists($path)) {
		    $makeDir = File::makeDirectory($path, 0777, true, true);
		}

    	$article 	= new Article();

    	$article->user_id 				= Auth::user()->id;
    	$article->article_category_id 	= $request['article_category_id'];
    	$article->title 				= $request['title'];
    	$article->content 				= $request['content'];
    	$article->is_active 			= '0';  // False For Kontributor

    	// Image Processing
    	$photo 	= $request['file'];
    	$extension = $photo->getClientOriginalExtension();
    	$allowed_filename = "i" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
    	$icon_name 		= 'thumb-' . $allowed_filename;

    	$uploadSuccess1 = $this->original( $photo, $allowed_filename, $path );
        $uploadSuccess2 = $this->icon( $photo, $icon_name, $path );

    	$article->image_path 			= $allowed_filename;

    	$article->save();
    	return Redirect::to('admin');
    }

    // Edit
    public function edit($id)
    {
    	$aumLists 	= AumList::where('id', '!=', '0')
    					->orderBy('name', 'ASC')
    					->get();

        $article    = Article::find($id);
        $aum_id     = $article->articleCategory->aum_list_id;
        $arCategories            = ArticleCategory::where([
                                    ['aum_list_id','=',$aum_id],
                                    ['name','!=', 'Pengumuman'],
                                    ])->get();
        return view('admin.artikel_kontributor.edit', [
                'artikel'  	 	=> $article,
                'arCategories'  => $arCategories,
                'aumLists'  	=> $aumLists,
        ]);
    }

	public function editPost(Request $request)
    {
        $aum_id     = $request['aum_id'];
        $id         = $request['id'];

        if(isset($request['file']))
        {
            $rules     = [
                            'file' => 'required|mimes:png,gif,jpeg,jpg,bmp|max:8192',
                        ];

            $messages   = [
                            'file.mimes' => 'Ekstensi File Gambar tidak didukung. Require(png,jpg,jpeg)',
                            'file.required' => 'File Gambar bermasalah. Coba gambar lain/ kompres gambar dengan benar (Cek: Resolusi maksimal lebar&tinggi 2000pixel, file maksimal 8mb)',
                            'file.max' => 'File gambar maksimal 8 MB',
                        ];
            $validator = Validator::make($request->all(), $rules, $messages);

            // dd($validator);

            if ($validator->fails()) {

                return redirect('admin/kelola/artikelKontributor/edit'.$id)
                            ->withErrors($validator)
                            ->withInput();
            }
        } // if isset file

        // Logic Image Folder Create For Each Aum
        $path   = public_path('files'.DIRECTORY_SEPARATOR.'artikel'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        if (!File::exists($path)) {
            $makeDir = File::makeDirectory($path, 0777, true, true);
        }

        $article    = Article::find($id);

        // $article->user_id               = Auth::user()->id;
        $article->article_category_id   = $request['article_category_id'];
        $article->title                 = $request['title'];
        $article->content               = $request['content'];
        $article->is_active             = 0; // Reset to false : to re-moderate

        if(isset($request['file']))
        {
            $oldPath        = public_path('files'.DIRECTORY_SEPARATOR.'artikel'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
            $oldOriPath         = $oldPath . $article->image_path;
            $oldThumbPath       = $oldPath . 'thumb-' .$article->image_path;

            // Image Processing New File
            $photo  = $request['file'];
            $extension = $photo->getClientOriginalExtension();
            $allowed_filename = "i" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
            $icon_name      = 'thumb-' . $allowed_filename;

            $uploadSuccess1 = $this->original( $photo, $allowed_filename, $path );
            $uploadSuccess2 = $this->icon( $photo, $icon_name, $path );

            $article->image_path            = $allowed_filename;

            // Delete old file if exist | If new file success uploaded
            if (File::exists($oldOriPath)) {
                $del = File::delete($oldOriPath);
            }
            if (File::exists($oldThumbPath)) {
                $del = File::delete($oldThumbPath);
            }
        } // EOF if isset(file)

        $article->save();
        return Redirect::to('admin')->with('success', '<b>Hore!</b> Artikel <em>'.$article->title.'</em> berhasil diupdate, <b>menunggu verifikasi ulang</b>');
    }

    public function deletePost(Request $request)
    {
        $id     = $request['id'];
        $article    = Article::find($id);
        // Get AUM id based on User
        if($article->is_active == '1') {
        	return 'Gagal. Untuk menghapus artikel aktif, hubungi staff bersangkutan';
        }

        $aum_id         = $article->articleCategory->aum_list_id;
        // Set Image Path
        $path   = public_path('files'.DIRECTORY_SEPARATOR.'artikel'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        $oriFile    = $path . $article->image_path;
        $iconFile   = $path . 'thumb-' . $article->image_path;

        // Delete Image File if Exist
        if (File::exists($oriFile)) {
            File::delete($oriFile);
        }
        if (File::exists($iconFile)) {
            File::delete($iconFile);
        }
        // Article Delete
        $article->delete();
        return 'Artikel berhasil dihapus';
    }

    public function getArticleCategory(Request $request)
    {
    	$aum_id 	= $request['aum_id'];
    	$articleCategory 	= ArticleCategory::where([
    							['aum_list_id', $aum_id],
    							['name', '!=', 'Pengumuman'],
    							])->get();
    	return response()->json($articleCategory);
    }

     // Image Processor
	 /**
	 * Optimize Original Image
	 */
    public function original( $photo, $filename, $path )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(800, null, function ($constraint) {
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
        $image = $manager->make( $photo )->resize(100, 100)
            ->save( $path  . $filename );

        return $image;
    }
}
