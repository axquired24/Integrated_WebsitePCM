<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Datatables;
use DB;
use Redirect;

use App\User;
use App\Models\AumList;
use App\Models\ArticleCategory;
use App\Models\File;
use App\Models\GalleryCategory;
use App\Models\Page;

class AumListController extends Controller
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
					])
					->get();
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

	    return Redirect::to('admin/kelola/aum');
    }

    public function edit($id)
    {
    	$aum 	= AumList::find($id);
    	return view('admin.aum_list.edit', ['aum' => $aum]);
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

	    return Redirect::to('admin/kelola/aum');
    }

    public function deletePost(Request $request)
    {
    	$id 	= $request['id'];

    	// Cek
    	$user 		= User::where('aum_list_id', '=', $id)->first();
    	$file 		= File::where('aum_list_id', '=', $id)->first();
    	$page 		= Page::where('aum_list_id', '=', $id)->first();
    	$articleCat = ArticleCategory::where('aum_list_id', '=', $id)->first();
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
    	elseif(isset($articleCat->id)){
    		return 'Error. Masih ada artikel dalam sub situs ini';
    	}
    	elseif(isset($galleryCat->id)){
    		return 'Error. Masih ada galeri dalam sub situs ini';
    	}
    	else {
    		// Delete Safely
    		$aum 	= AumList::find($id);
    		$del 	= $aum->delete();
    		return 'Hapus berhasil';
    	} // Close if Cek
    }

}
