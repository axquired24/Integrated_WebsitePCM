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
use App\Models\Page;

class PageController extends Controller
{

	public function index()
	{
		$aum_id 	= Auth::user()->aum_list_id;
		$aum 		= AumList::find($aum_id);
		return view('admin.halaman.list', ['aum' => $aum]);
	}

	public function indexData(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
		// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= Page::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'pages.*',
					// Or Select all with table.*
					])
                    ->where('aum_list_id', '=', $aum_id)
					->get();
        // if(isset)
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
                ->editColumn('rownum', function($table) {
                    return $table->rownum . '<div class="hidden-sm-down"><img class="img-fluid" width="100px" src="'.url('files/halaman/'.$table->aum_list_id.'/thumb-'.$table->image_path).'" alt="Gambar '.$table->title.'"></div>';
                })
                ->editColumn('title', function($table) {
                    $detailLink     = url('halaman/'.$table->id);
                    if($table->id != 1) {
                        $detailLink     = url('aum/'.$table->aumList->seo_name.'/halaman/'.$table->id);
                    }
                    return $table->title .
                    '<hr><div align="text-center" class="btn-group">
                      <a title="hapus" href="javascript:void;" onclick="deleteBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
                      <a title="ubah" href="'.url('admin/halaman/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                      <a title="detail" href="'.$detailLink.'" target="_blank" class="btn btn-sm btn-secondary"><span class="fa fa-file-text-o"></span></a>
                      </div>';
                })
	    		->make(true);
    }


    public function deletePost(Request $request)
    {
        $id     = $request['id'];
        $page    = Page::find($id);

        if($page->title == 'Profil') {
            return 'Halaman Profil tidak bisa dihapus';
        }

        // Get AUM id based on User
        $aum_id         = Auth::user()->aum_list_id;
        // Set Image Path
        $path   = public_path('files'.DIRECTORY_SEPARATOR.'halaman'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        $oriFile    = $path . $page->image_path;
        $iconFile   = $path . 'thumb-' . $page->image_path;

        // Delete Image File if Exist
        if (File::exists($oriFile)) {
            File::delete($oriFile);
        }
        if (File::exists($iconFile)) {
            File::delete($iconFile);
        }
        // Article Delete
        $page->delete();
        return 'Halaman berhasil dihapus';
    }

    public function add()
    {
    	return view('admin.halaman.add');
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

			return redirect('admin/halaman/add')
                        ->withErrors($validator)
                        ->withInput();
        }

    	// Logic Image Folder Create For Each Aum
    	$path 	= public_path('files'.DIRECTORY_SEPARATOR.'halaman'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
		if (!File::exists($path)) {
		    $makeDir = File::makeDirectory($path, 0777, true, true);
		}

    	$page 	= new Page();

    	$page->aum_list_id			= Auth::user()->aum_list_id;
    	$page->title 				= $request['title'];
    	$page->content 				= $request['content'];

    	// Image Processing
    	$photo 	= $request['file'];
    	$extension = $photo->getClientOriginalExtension();
    	$allowed_filename = "i" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
    	$icon_name 		= 'thumb-' . $allowed_filename;

    	$uploadSuccess1 = $this->original( $photo, $allowed_filename, $path );
        $uploadSuccess2 = $this->icon( $photo, $icon_name, $path );

    	$page->image_path 			= $allowed_filename;

    	$page->save();
    	return Redirect::to('admin/halaman');
    }

    // Edit
    public function edit($id)
    {
        $aum_id     = Auth::user()->aum_list_id;
        $page    	= Page::find($id);
        return view('admin.halaman.edit', [
                'page'   => $page,
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

                return redirect('admin/halaman/edit/'.$id)
                            ->withErrors($validator)
                            ->withInput();
            }
        } // if isset file

        // Logic Image Folder Create For Each Aum
        $path   = public_path('files'.DIRECTORY_SEPARATOR.'halaman'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        if (!File::exists($path)) {
            $makeDir = File::makeDirectory($path, 0777, true, true);
        }

        $page    = Page::find($id);

        // $page->user_id               = Auth::user()->id;
        $page->title                 = $request['title'];
        $page->content               = $request['content'];

        if(isset($request['file']))
        {
            $oldPath        = public_path('files'.DIRECTORY_SEPARATOR.'halaman'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
            $oldOriPath         = $oldPath . $page->image_path;
            $oldThumbPath       = $oldPath . 'thumb-' .$page->image_path;

            // Image Processing New File
            $photo  = $request['file'];
            $extension = $photo->getClientOriginalExtension();
            $allowed_filename = "i" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
            $icon_name      = 'thumb-' . $allowed_filename;

            $uploadSuccess1 = $this->original( $photo, $allowed_filename, $path );
            $uploadSuccess2 = $this->icon( $photo, $icon_name, $path );

            $page->image_path            = $allowed_filename;

            // Delete old file if exist | If new file success uploaded
            if (File::exists($oldOriPath)) {
                $del = File::delete($oldOriPath);
            }
            if (File::exists($oldThumbPath)) {
                $del = File::delete($oldThumbPath);
            }
        } // EOF if isset(file)

        $page->save();
        return Redirect::to('admin/halaman');
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