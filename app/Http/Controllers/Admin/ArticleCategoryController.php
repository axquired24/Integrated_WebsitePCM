<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Datatables;
use DB;
use Redirect;
// use App\User;
// use App\Models\AumList;
use App\Models\Article;
use App\Models\ArticleCategory;

class ArticleCategoryController extends Controller
{
    public function index()
    {
    	return view('admin.artikel_kategori.list');
    }

    public function indexData(Request $request)
    {
    	// Just to display mysql num rows, add this code
        $aum_id     = Auth::user()->aum_list_id;
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= ArticleCategory::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'article_categories.*',
					// Or Select all with table.*
					])
                    ->where([
                            ['name', '!=', 'Pengumuman'],
                            ['aum_list_id', '=', $aum_id]
                            ]);
        // if(isset)
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
	    		->addColumn('action', function($table){
	    			return 
	    			'<a title="hapus" href="javascript:void" onclick="deleteBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="ubah" href="'.url('admin/artikel/kategori/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>';
	    		})
	    		->make(true);
    }

    public function add()
    {
    	return view('admin.artikel_kategori.add');
    }

    public function addPost(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	$this->validate($request, [
            'name' => 'unique:article_categories,name,NULL,id,aum_list_id,'.$aum_id
	    ]);

	    $arCategory 		= new ArticleCategory();
	    $arCategory->name 	= $request['name'];
	    $arCategory->aum_list_id 	= $aum_id;
	    $arCategory->save();

	    return Redirect::to('admin/artikel/kategori');
    }

    public function deletePost(Request $request)
    {
    	$id 			= $request['id'];
    	$arCategory 	= ArticleCategory::find($id);
    	// Cek ada artikel tersambung / tidak
    	$article 		= Article::where('article_category_id',$id)->first();
    	if(isset($article->id))
    	{
    		return 'Error. Masih ada artikel dalam kategori ini. hapus terlebih dahulu.';
    	}
    	else
    	{
    		$arCategory->delete();
    		return 'Hapus berhasil';
    	}
    }

    public function edit($id)
    {
    	$arCategory 	= ArticleCategory::find($id);
    	return view('admin.artikel_kategori.edit', [
    				'arCategory' => $arCategory
    			]);
    }

    public function editPost(Request $request)
    {
    	$id 		= $request['id'];
    	$aum_id 	= Auth::user()->aum_list_id;
    	$this->validate($request, [
            'name' => 'unique:article_categories,name,'.$id.',id,aum_list_id,'.$aum_id
	    ]);

	    $arCategory 		= ArticleCategory::find($id);
	    $arCategory->name 	= $request['name'];
	    $arCategory->aum_list_id 	= $aum_id;
	    $arCategory->save();

	    return Redirect::to('admin/artikel/kategori');
    }
}
