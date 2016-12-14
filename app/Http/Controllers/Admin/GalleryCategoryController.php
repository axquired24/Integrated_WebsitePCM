<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

use Auth;
use Datatables;
use DB;
use Redirect;
// use App\User;
// use App\Models\AumList;
use App\Models\Gallery;
use App\Models\GalleryCategory;

class GalleryCategoryController extends Controller
{
    public function index()
    {
    	return view('admin.galeri_kategori.list');
    }

    public function indexData(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= GalleryCategory::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'gallery_categories.*',
					// Or Select all with table.*
					])
					->where('aum_list_id', $aum_id);
        // if(isset)
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
	    		->editColumn('name', function($table){
	    			$jml 	= Gallery::where('gallery_category_id', $table->id)->count();
	    			return $table->name . ' <small>( '. $jml .' gambar)</small>';
	    		})
	    		->addColumn('action', function($table){
	    			return
	    			'<a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="Ubah nama galeri" href="javascript:" onclick="editBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
	    				<a title="Kelola Gambar" href="'.url('admin/galeri/kategori/edit/'.$table->id).'" class="btn btn-sm btn-secondary"><span class="fa fa-image"></span></a>';
	    		})
	    		->make(true);
    }

    public function addPost(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;

	    $arCategory 		= new GalleryCategory();
	    $arCategory->name 	= $request['name'];
	    $arCategory->aum_list_id 	= $aum_id;
	    $arCategory->save();

	    return 'Galeri berhasil ditambahkan. ' . $request['name'];
    }

    // Delete Gallery Category & All Gallery Items
    public function deletePost(Request $request)
    {
    	$id 			= $request['id'];
    	$arCategory 	= GalleryCategory::find($id);

    	// Init Variable & Path
    	$aum_id     = Auth::user()->aum_list_id;
        $full_size_dir = $path    = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        $icon_size_dir = $path    = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR.'thumb-');

    	// Delete Gallery Items
    	$images 		= Gallery::where('gallery_category_id',$id)->get();
    	foreach ($images as $image) {
	    	$full_path1 = $full_size_dir . $image->filename;
	        $full_path2 = $icon_size_dir . $image->filename;

	        // Delete if any gallery item
	        if ( File::exists( $full_path1 ) )
	        {
	            File::delete( $full_path1 );
	        }
	        if ( File::exists( $full_path2 ) )
	        {
	            File::delete( $full_path2 );
	        }
	        // EOF Delete if any gallery item

	        // delete gallery items from db
	        $image->delete();
    	} // EOF Foreach

    	$arCategory->delete(); // delete gallery category

    	return 'Galeri & semua gambar berhasil dihapus';
    }

    // Display Edit Gallery Item page
    public function edit($id)
    {
    	$arCategory 	= GalleryCategory::find($id);
    	$images 		= Gallery::where('gallery_category_id', $id)->get();
    	return view('admin.dropzone.editfile', [
    				'arCategory' => $arCategory,
    				'images' => $images,
    			]);
    }

    // Edit Gallery Category Name Process
    public function editPost(Request $request)
    {
    	$id 		= $request['id'];
    	$name 		= e($request['name']);

	    $arCategory 		= GalleryCategory::find($id);
	    $arCategory->name 	= $request['name'];
	    $arCategory->save();

	    return 'Galeri berhasil berubah nama. ('. $request['name'] .')';
    }
}
