<?php

namespace App\Http\Controllers\Admin;

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

class ArticleController extends Controller
{
	public function index()
	{
		$aum_id 	= Auth::user()->aum_list_id;
		$aum 		= AumList::find($aum_id);
        // kontributor view
        if(Auth::user()->level == 'kontributor') {
            return view('admin.artikel_kontributor.list', ['aum' => $aum]);
        }
        // else
		return view('admin.artikel.list', ['aum' => $aum]);
	}

	public function indexData(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
		// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= Article::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'articles.id as id', 'articles.article_category_id as article_category_id', 'articles.title as title', 'articles.image_path as image_path', 'articles.tag as tag', 'users.name as user_name', 'article_categories.name as category_name',
					// Or Select all with table.*
					])
                    ->join('users', 'articles.user_id', '=', 'users.id')
                    ->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                    ->where([
                            ['articles.is_active',1],
                            ['article_categories.name', '!=', 'Pengumuman'],
                            ['article_categories.aum_list_id', $aum_id],
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
                    return $table->rownum . '<div class="hidden-sm-down"><img class="img-fluid" width="100px" src="'.url('files/artikel/'.$table->articleCategory->aum_list_id.'/thumb-'.$table->image_path).'" alt="Gambar '.$table->title.'"></div>';
                })
                ->editColumn('title', function($table) {
                    $tag = '';
                    if(($table->tag == 'direct') && ($table->articleCategory->aum_list_id == '1'))
                    {
                        $tag = '<span class="tag tag-default"><a class="text-white" href="javascript:" onclick="unsetCastBtn('.$table->id.', \''.$table->title.'\')">Copot Broadcast</a></span>';
                    }
                    $ret    = $table->title . '<br> <span class="tag tag-primary">'.$table->articleCategory->name.'</span> '.$tag.'<br>'.
                    '<hr><div align="text-center" class="btn-group">
                      <a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
                      <a title="ubah" href="'.url('admin/kelola/artikel/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                      ';
                      if(($table->tag != 'direct') && ($table->articleCategory->aum_list_id == '1'))
                      {
                        $ret .= '<a title="Broadcast Konten ini" href="javascript:" onclick="setCastBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-secondary"><span class="fa fa-paper-plane"></span></a>';
                      }
                      return $ret . '</div>';
                })
	    		->make(true);
    }

    public function indexNonAktif()
    {
        $aum_id     = Auth::user()->aum_list_id;
        $aum        = AumList::find($aum_id);
        return view('admin.artikel.list_nonaktif', ['aum' => $aum]);
    }

    public function indexNonAktifData(Request $request)
    {
        $aum_id     = Auth::user()->aum_list_id;
        // Just to display mysql num rows, add this code
        DB::statement(DB::raw('set @rownum=0'));
        $table  = Article::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
                    'articles.id as id', 'articles.article_category_id as article_category_id', 'articles.title as title', 'articles.image_path as image_path', 'users.name as user_name', 'article_categories.name as category_name',
                    // Or Select all with table.*
                    ])->join('users', 'articles.user_id', '=', 'users.id')
                    ->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                    ->where([
                            ['articles.is_active',0],
                            ['article_categories.name', '!=', 'Pengumuman'],
                            ['article_categories.aum_list_id', $aum_id],
                    ])->get();
        // if(isset)
        $datatables = Datatables::of($table);
        if($keyword = $request->get('search')['value'])
        {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables
                ->editColumn('rownum', function($table) {
                    return $table->rownum . '<div class="hidden-sm-down"><img class="img-fluid" width="100px" src="'.url('files/artikel/'.$table->articleCategory->aum_list_id.'/thumb-'.$table->image_path).'" alt="Gambar '.$table->title.'"></div>';
                })
                ->editColumn('title', function($table) {
                    return $table->title . '<br> <span class="tag tag-primary">'.$table->articleCategory->name.'</span><br>'.
                    '<hr><div align="text-center" class="btn-group">
                      <a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
                      <a title="ubah" href="'.url('admin/kelola/artikel/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                      <a title="Preview" href="'.url('artikel/'.$table->id).'" target="_blank" class="btn btn-sm btn-secondary"><span class="fa fa-file-text-o"></span></a>
                      </div>';
                })
                ->make(true);
    }

    public function indexPengumuman()
    {
        $aum_id     = Auth::user()->aum_list_id;
        $aum        = AumList::find($aum_id);
        return view('admin.artikel.list_pengumuman', ['aum' => $aum]);
    }

    public function indexPengumumanData(Request $request)
    {
        $aum_id     = Auth::user()->aum_list_id;
        // Just to display mysql num rows, add this code
        DB::statement(DB::raw('set @rownum=0'));
        $table  = Article::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
                    'articles.id as id', 'articles.article_category_id as article_category_id', 'articles.title as title', 'articles.image_path as image_path', 'articles.tag as tag', 'users.name as user_name', 'article_categories.name as category_name',
                    // Or Select all with table.*
                    ])->join('users', 'articles.user_id', '=', 'users.id')
                    ->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                    ->where([
                            ['articles.is_active',1],
                            ['article_categories.name', '=', 'Pengumuman'],
                            ['article_categories.aum_list_id', $aum_id],
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
                    return $table->rownum . '<div class="hidden-sm-down"><img class="img-fluid" width="100px" src="'.url('files/artikel/'.$table->articleCategory->aum_list_id.'/thumb-'.$table->image_path).'" alt="Gambar '.$table->title.'"></div>';
                })
                ->editColumn('title', function($table) {
                    $tag = '';
                    if(($table->tag == 'direct') && ($table->articleCategory->aum_list_id == '1'))
                    {
                        $tag = '<span class="tag tag-default"><a class="text-white" href="javascript:" onclick="unsetCastBtn('.$table->id.', \''.$table->title.'\')">Copot Broadcast</a></span>';
                    }
                    $ret    = $table->title . '<br> <span class="tag tag-primary">'.$table->articleCategory->name.'</span> '.$tag.'<br>'.
                    '<hr><div align="text-center" class="btn-group">
                      <a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
                      <a title="ubah" href="'.url('admin/kelola/artikel/edit/'.$table->id.'/pengumuman').'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                      ';
                      if(($table->tag != 'direct') && ($table->articleCategory->aum_list_id == '1'))
                      {
                        $ret .= '<a title="Broadcast Konten ini" href="javascript:" onclick="setCastBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-secondary"><span class="fa fa-paper-plane"></span></a>';
                      }
                      return $ret . '</div>';
                })
                ->make(true);
    }

    public function indexCast()
    {
        $aum_id     = Auth::user()->aum_list_id;
        $aum        = AumList::find($aum_id);
        return view('admin.artikel.list_cast', ['aum' => $aum]);
    }

    public function indexCastData(Request $request)
    {
        $aum_id     = Auth::user()->aum_list_id;
        // Just to display mysql num rows, add this code
        DB::statement(DB::raw('set @rownum=0'));
        $table  = Article::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
                    'articles.id as id', 'articles.article_category_id as article_category_id', 'articles.title as title', 'articles.image_path as image_path', 'articles.tag as tag', 'users.name as user_name',
                    // Or Select all with table.*
                    ])->join('users', 'articles.user_id', '=', 'users.id')
                    ->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                    ->where([
                            ['articles.is_active',1],
                            ['articles.tag','direct'],
                            ['article_categories.aum_list_id', $aum_id],
                            ])->get();
        // if(isset)
        $datatables = Datatables::of($table);
        if($keyword = $request->get('search')['value'])
        {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables
                ->editColumn('rownum', function($table) {
                    return $table->rownum . '<div class="hidden-sm-down"><img class="img-fluid" width="100px" src="'.url('files/artikel/'.$table->articleCategory->aum_list_id.'/thumb-'.$table->image_path).'" alt="Gambar '.$table->title.'"></div>';
                })
                ->editColumn('title', function($table) {
                    $tag = '';
                    if($table->tag == 'direct')
                    {
                        $tag = '<span class="tag tag-default"><a class="text-white" href="javascript:" onclick="unsetCastBtn('.$table->id.', \''.$table->title.'\')">Copot Broadcast</a></span>';
                    }
                    $ret    = $table->title . '<br> <span class="tag tag-primary">'.$table->articleCategory->name.'</span> '.$tag.'<br>'.
                    '<hr><div align="text-center" class="btn-group">
                      <a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
                      <a title="ubah" href="'.url('admin/kelola/artikel/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                      ';
                      if($table->tag != 'direct')
                      {
                        $ret .= '<a title="Broadcast Konten ini" href="javascript:" onclick="setCastBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-secondary"><span class="fa fa-paper-plane"></span></a>';
                      }
                      return $ret . '</div>';
                })
                ->make(true);
    }

    public function setCast(Request $request)
    {
        $id         = $request['id'];
        $article    = Article::find($id);
        $article->tag = 'direct';
        $article->save();

        return 'Artikel '. $article->title .' berhasil di broadcast';
    }

    public function unsetCast(Request $request)
    {
        $id         = $request['id'];
        $article    = Article::find($id);
        $article->tag = '';
        $article->save();

        return 'Broadcast '. $article->title .' dicabut';
    }

    public function deletePost(Request $request)
    {
        $id     = $request['id'];
        $article    = Article::find($id);
        // Get AUM id based on User
        $aum_id         = Auth::user()->aum_list_id;
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

    public function add($pengumuman='')
    {
    	$aum_id 		= Auth::user()->aum_list_id;
        if($pengumuman == 'pengumuman')
        {
            $pengumuman     = ArticleCategory::where([
                                            ['aum_list_id',$aum_id],
                                            ['name','=', 'Pengumuman'],
                                            ])->first();
        }

    	$arCategory 	= ArticleCategory::where([
                                        ['aum_list_id',$aum_id],
                                        ['name','!=', 'Pengumuman'],
                                        ])->get();
    	$catCount 		= ArticleCategory::where([
                                        ['aum_list_id',$aum_id],
                                        ['name','!=', 'Pengumuman'],
                                        ])->count();
    	return view('admin.artikel.add', [
    			'arCategory' => $arCategory,
    			'catCount' 	=> $catCount,
                'pengumuman' => $pengumuman,
    		]);
    }

    public function addPost(Request $request)
    {
    	// dd($request);
    	$aum_id 	= Auth::user()->aum_list_id;

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
    	$article->is_active 			= 1;  // True

    	// Image Processing
    	$photo 	= $request['file'];
    	$extension = $photo->getClientOriginalExtension();
    	$allowed_filename = "i" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
    	$icon_name 		= 'thumb-' . $allowed_filename;

    	$uploadSuccess1 = $this->original( $photo, $allowed_filename, $path );
        $uploadSuccess2 = $this->icon( $photo, $icon_name, $path );

    	$article->image_path 			= $allowed_filename;

    	$article->save();
        if(isset($request['pengumuman']))
        {
            return Redirect::to('admin/kelola/artikel/pengumuman');
        }
    	return Redirect::to('admin/kelola/artikel');
    }

    // Edit
    public function edit($id,$pengumuman='')
    {
        $aum_id     = Auth::user()->aum_list_id;
        if($pengumuman == 'pengumuman')
        {
            $pengumuman     = ArticleCategory::where([
                                            ['aum_list_id',$aum_id],
                                            ['name','=', 'Pengumuman'],
                                            ])->first();
        }
        $article    = Article::find($id);
        $selectedCategory     = ArticleCategory::where('id','=',$article->article_category_id)->first();
        $oCategory            = ArticleCategory::where([
                                    ['id','!=',$article->article_category_id],
                                    ['aum_list_id','=',$aum_id],
                                    ['name','!=', 'Pengumuman'],
                                    ])->get();
        return view('admin.artikel.edit', [
                'selectedCategory' => $selectedCategory,
                'article'   => $article,
                'oCategory'  => $oCategory,
                'pengumuman'  => $pengumuman,
        ]);
    }

    public function editPost(Request $request)
    {
        $aum_id     = Auth::user()->aum_list_id;
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

                return redirect('admin/kelola/artikel/edit/'.$id)
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
        $article->is_active             = $request['is_active'];;  // True

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
        if(isset($request['pengumuman']))
        {
            return Redirect::to('admin/kelola/artikel/pengumuman');
        }
        return Redirect::to('admin/kelola/artikel');
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
