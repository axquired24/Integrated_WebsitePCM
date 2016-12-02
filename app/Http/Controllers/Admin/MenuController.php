<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Datatables;
use DB;
use Redirect;
use App\Models\Menu;
use App\Models\AumList;

class MenuController extends Controller
{
    public function index()
    {
    	return view('admin.menu.list');
    }

    public function indexData(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= Menu::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'menus.*',
					// Or Select all with table.*
					])
					->where('aum_list_id', $aum_id)
					->get();
        // if(isset)
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
	    		->editColumn('name', function($table){
	    			$addon 	= '';
	    			if($table->parent != '')
	    			{
	    				$parent = Menu::find($table->parent);
	    				$addon 	= ' <br><span class="tag tag-default">Submenu : '.$parent->name.'</span>';
	    			}
	    			return $table->name . '<br><small>( Link: '. $table->link .')</small>'. $addon;
	    		})
	    		->addColumn('action', function($table){
	    			return
	    			'<a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="Ubah judul file" href="javascript:" onclick="editBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
	    				';
	    		})
	    		->make(true);
    }

    public function add()
    {
    	return view('admin.menu.add');
    }

    // Pas Add -> Push menu baru ke urutan ('Kalo udah ada urutan')
    // Pas Hapus -> Hapus dari urutan ('kalo udah ada urutan')

    public function addPost(Request $request)
    {
    	$aum_id = Auth::user()->aum_list_id;
    	$menu 	= new Menu();

    	$menu->aum_list_id	 = $aum_id;
    	$menu->name 	= $request['name'];
    	$menu->link 	= $request['link'];

    	$menu->save();
    	return Redirect::to('admin/menu')->with('success', '<b>Hore!</b> Menu '.$request['name'].' berhasil ditambahkan');
    }

    public function editOrder()
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	$aum 		= AumList::find($aum_id);
    	$menus 		= Menu::where('aum_list_id', $aum_id)->get();
    	return view('admin.menu.edit_order', [
    				'menus' => $menus,
    				'aum' 	=> $aum,
    				]);
    }

    public function editOrderPost(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	$aum 		= AumList::find($aum_id);

    	if(isset($request['resetMenu'])){
    		$aum->menu_order = '';
    		$aum->save();
    		return Redirect::to('admin/menu')->with('success', '<b>Hore!</b> Susunan menu direset.');
    	}
    	$aum->menu_order = $request['menu_order'];
    	$aum->save();

    	return Redirect::to('admin/menu')->with('success', '<b>Hore!</b> Menu berhasil disusun.');
    }

    public function jajalMenu()
    {
    	$serialize 		= '[{"id":1},{"id":5,"children":[{"id":7},{"id":6},{"id":3},{"id":8}]},{"id":2,"children":[{"id":4},{"id":9},{"id":10}]},{"id":11},{"id":12}]';
    	$ser 	= json_decode($serialize);
    	// dd($ser);
    	foreach ($ser as $key => $value) {
    		echo 'Level1 :' . $value->id . '<br>';
    		if(isset($value->children))
    		{
    			// dd($value->children);
    			foreach ($value->children as $keychildren => $valuechildren) {
    				echo '&nbsp; - Level2 :' . $valuechildren->id . '<br>';
    			}
    		}
    	}
    	// dd($ser);
    }
}
