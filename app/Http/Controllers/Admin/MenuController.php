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
        // Auto Refresh Menu
        $aum_id     = Auth::user()->aum_list_id;
        
        // After editing any content - Link will automatically update
        $this->refreshLink($aum_id);
        $this->refreshPageLink($aum_id);

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
					->where('aum_list_id', $aum_id);
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
	    			'<a title="hapus" onclick="return confirm(\'Hapus menu '.$table->name.'?\')" href="'.url('admin/menu/delete/'.$table->id).'" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="Ubah" href="'.url('admin/menu/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
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

        // Reset Menu
        $aum    = AumList::find($aum_id);
        $aum->menu_order = '';
        $aum->save();
    	return Redirect::to('admin/menu')->with('success', '<b>Hore!</b> Menu '.$request['name'].' berhasil ditambahkan. Silahkan susun ulang menu');
    }

    public function edit($id)
    {
        $menu   = Menu::find($id);
        return view('admin.menu.edit', ['menu' => $menu]);
    }

    public function editPost(Request $request)
    {
        $id     = $request['id'];
        $menu   = Menu::find($id);

        $menu->name     = $request['name'];
        $menu->link     = $request['link'];

        $menu->save();
        return Redirect::to('admin/menu/dtable')->with('success', '<b>Hore!</b> Menu '.$request['name'].' berhasil diedit');
    }

    public function delete($id)
    {
        $menu   = Menu::find($id);
        // Undeleteable
        $undeleteable   = array('Profil', 'Galeri', 'Download');
        if(in_array($menu->name, $undeleteable)) {
            return Redirect::to('admin/menu/dtable')->with('success', '<b>Gagal!</b> Menu '.$menu->name.' tidak boleh dihapus');
        }
        $name   = $menu->name;
        $menu->delete();

        // Reset Menu
        $aum_id = Auth::user()->aum_list_id;
        $aum    = AumList::find($aum_id);
        $aum->menu_order = '';
        $aum->save();
        return Redirect::to('admin/menu/dtable')->with('success', '<b>Hore!</b> Menu '.$name.' berhasil dihapus. Silahkan susun ulang menu');
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

    public function refreshLink($aum_id)
    {
        $refreshable   = array('galeri'=>'Galeri', 'daftarfile'=>'Download');
        foreach ($refreshable as $key => $value) {
            // dd($value);
            $menu   = Menu::where([
                                ['name', $value],
                                ['aum_list_id', $aum_id],
                                ])
                                ->first();
            // dd($menu);
            if(isset($menu->name)) {
                if($aum_id == '1') {
                    // base refresh URL
                    $base_rurl = url('/');
                }
                else {
                    $aum       = AumList::find($aum_id);
                    $base_rurl = url('aum/'.$aum->seo_name);
                }
                $menu->link     = $base_rurl . '/' . $key;
                $menu->save();
            } // isset menu->name
        } // foreach
    }

    public function refreshPageLink($aum_id)
    {
        /**
        * Updating link when seo_name of sub site changed
        *
        **/
        if($aum_id  != 1) { // 1 = PCM Kartasura
            $ad     = array();
            $aum    = AumList::find($aum_id); // find AUM
            $menus  = Menu::where('aum_list_id', $aum_id)->get(); // Get this AUM's menu
            foreach ($menus as $menu) {
                $menuselect = Menu::find($menu->id);  // SELECT Found Menu
                $exmenu     = explode('/', $menuselect->link); // Explode with '/'
                $ekor       = end($exmenu); // GET page_id
                $subekor    = prev($exmenu); // Get page initial = 'halaman'
                // Update Link if any halaman
                if($subekor == 'halaman') {  // if halaman
                    array_push($ad, $exmenu);
                    $refreshLink        = url('aum/'.$aum->seo_name.'/halaman/'.$ekor);
                    $menuselect->link   = $refreshLink;
                    $menuselect->save();
                }
            } // EOF Foreach menus
            return $ad; // for check
        } // EOF if
    }

    // public function jajalMenu()
    // {
    // 	$serialize 		= '[{"id":1},{"id":5,"children":[{"id":7},{"id":6},{"id":3},{"id":8}]},{"id":2,"children":[{"id":4},{"id":9},{"id":10}]},{"id":11},{"id":12}]';
    // 	$ser 	= json_decode($serialize);
    // 	// dd($ser);
    // 	foreach ($ser as $key => $value) {
    // 		echo 'Level1 :' . $value->id . '<br>';
    // 		if(isset($value->children))
    // 		{
    // 			// dd($value->children);
    // 			foreach ($value->children as $keychildren => $valuechildren) {
    // 				echo '&nbsp; - Level2 :' . $valuechildren->id . '<br>';
    // 			}
    // 		}
    // 	}
    // }
}
