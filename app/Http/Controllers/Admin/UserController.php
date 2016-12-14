<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Datatables;
use DB;
use Redirect;
use App\User;
use App\Models\AumList;
use App\Models\Article;

class UserController extends Controller
{
    public function index()
    {
    	return view('admin.kelola_user.list');
    }

    public function indexNonAktif()
    {
        return view('admin.kelola_user.list_non_aktif');
    }

    public function indexData(Request $request)
    {
		// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= User::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'users.*',
					// Or Select all with table.*
					])
                    ->where('is_active',1)
                    ->get();
        // if(isset)
		$datatables = Datatables::of($table);
		if($keyword = $request->get('search')['value'])
		{
			$datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
		}

	    return $datatables
	    		->editColumn('name', function($table) {
	    			return $table->name . '<br> <small>( <a href="mailto:'.$table->email.'">'.$table->email.'</a> )</small><br>'
	    			.
	    			'<a title="hapus" href="javascript:void" onclick="deleteBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="ubah" href="'.url('admin/kelola/pengguna/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
	    				<a title="detail" onclick="detail('.$table->id.', \''.$table->name.'\')" href="javascript:undefined" class="btn btn-sm btn-secondary"><span class="fa fa-file-text-o"></span></a>';
	    		})
                ->editColumn('level', function($table) {
                    $addcol     = '<br>' . '<small>('.$table->aumList->name.')</small>';
                    return '<b>'.$table->level.'</b>' . $addcol;
                })
	    		->make(true);
    }

    public function indexDataNonAktif(Request $request)
    {
        // Just to display mysql num rows, add this code
        DB::statement(DB::raw('set @rownum=0'));
        $table  = User::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
                    'users.*',
                    // Or Select all with table.*
                    ])
                    ->where('is_active',0)
                    ->get();
        // if(isset)
        $datatables = Datatables::of($table);
        if($keyword = $request->get('search')['value'])
        {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables
                ->editColumn('name', function($table){
                    return $table->name . '<br> <small>( <a href="mailto:'.$table->email.'">'.$table->email.'</a> )</small><br>'
                    .
                    '<a title="hapus" href="javascript:void" onclick="deleteBtn('.$table->id.', \''.$table->name.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
                        <a title="ubah" href="'.url('admin/kelola/pengguna/edit/'.$table->id).'" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                        <a title="detail" onclick="detail('.$table->id.', \''.$table->name.'\')" href="javascript:undefined" class="btn btn-sm btn-secondary"><span class="fa fa-file-text-o"></span></a>';
                })
                ->make(true);
    }

    public function detailData(Request $request)
    {
    	$id 	= $request['id'];
    	$user 	= User::find($id);

    	// Cek if aum_list_id is any
    	if(isset($user->aumList->name))
    	{
    		$aum_name 	= '<a href="'.url('admin/kelola/aum/detail/'.$user->aum_list_id).'">'.$user->aumList->name.'</a>';
    	}
    	else
    	{
    		$aum_name 	= 'Belum ada';
    	}

    	// Check user status
    	if($user->is_active == 0)
    	{
    		$status = 'non-aktif';
    	}
    	elseif($user->is_active == 1)
    	{
    		$status = 'aktif';
    	}
    	else {$status = 'tidak terdefinisi';}

    	echo $data 	= '
    	<div class="table-responsive">
            <br>
            <table class="table table-striped">
              <tr>
                <td><b>Nama</b></td>
                <td>: '.$user->name.'</td>
              </tr>
              <tr>
                <td><b>NBM</b></td>
                <td>: '.$user->nbm.'</td>
              </tr>
              <tr>
                <td><b>Alamat</b></td>
                <td>: '.$user->address.'</td>
              </tr>
              <tr>
                <td><b>Telepon</b></td>
                <td>: '.$user->phone.'</td>
              </tr>
              <tr>
                <td><b>Email</b></td>
                <td>: '.$user->email.'</td>
              </tr>
              <tr>
                <td><b>Level</b></td>
                <td>: '.$user->level.'</td>
              </tr>
              <tr>
                <td><b>Asal Instansi</b></td>
                <td>: '.$aum_name.'</td>
              </tr>
              <tr>
                <td><b>Status</b></td>
                <td>: '.$status.'</td>
              </tr>
              <tr>
                <td><b>Terakhir diperbaharui</b></td>
                <td>: '.date_format($user->updated_at,"d F Y").'</td>
              </tr>
            </table>
          </div>
        </div>';
    	// return response()->json($user);
    }

    // Add User - View
    public function add()
    {
    	$aums 	= AumList::all();
    	return view('admin.kelola_user.add', ['aums'=>$aums]);
    }

    // Add User - Action
    public function addPost(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
	    ]);

    	$user 	= new User();
    	$user->name 	= $request['name'];
    	$user->nbm 		= $request['nbm'];
    	$user->alamat 	= $request['alamat'];
    	$user->phone 	= $request['phone'];
    	$user->aum_list_id 	= $request['aum_list_id'];
    	$user->email 		= $request['email'];
    	$user->password 	= bcrypt($request['password']);
    	$user->level 	= $request['level'];
    	$user->is_active 	= $request['status'];

    	$user->save();
    	return Redirect::to('admin/kelola/pengguna');
    }

    // Edit User - View
    public function edit($id)
    {
        $noadmin    = '';
        if(Auth::user()->level != 'admin')
        {
            $noadmin    = 'noadmin';
        }
    	$user = User::find($id);
    	// Aum Tanpa user
    	$aums 	= AumList::where('id', '!=', $user->aum_list_id)->get();

    	// Level array
    	$levels = array('admin','staff','kontributor');
    	$key = array_search($user->level, $levels);
    	// Remove level duplicated by user->level
    	if($key !== false){
    		unset($levels[$key]);
    	}

    	// status check
    	$stat 	  = array('0'=>'non-aktif','1'=>'aktif');
    	$statuses = array(0,1);
    	$key = array_search($user->is_active, $statuses);
    	// Remove level duplicated by user->level
    	if($key !== false){
    		unset($statuses[$key]);
    	}

    	return view('admin.kelola_user.edit', [
    										'user' => $user,
    										'aums' => $aums,
    										'levels' => $levels,
    										'statuses' => $statuses,
    										'stat' => $stat,
                                            'noadmin' => $noadmin,
    										]);
    }

    // Edit User - Action
    public function editPost(Request $request)
    {
    	$id 	= $request['id'];
    	$this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'unique:users,email,'.$id,
            // 'password' => 'required|min:6',
	    ]);

    	$user 	= User::find($id);
    	$user->name 	= $request['name'];
    	$user->nbm 		= $request['nbm'];
    	$user->alamat 	= $request['alamat'];
    	$user->phone 	= $request['phone'];
    	$user->email 		= $request['email'];

    	if($request['password'] != ''){
    		$user->password 	= bcrypt($request['password']);
    	}

        // Prevent edit from noadmin
        if(isset($request['level']) && isset($request['aum_list_id']))
        {
            $user->aum_list_id  = $request['aum_list_id'];
        	$user->level 	= $request['level'];
        	$user->is_active 	= $request['status'];
        }

    	$user->save();
    	return Redirect::to('admin/kelola/pengguna');
    }

    // Delete User - Action
    public function deletePost(Request $request)
    {
    	$id 		= $request['id'];
    	$user 		= User::find($id);
    	$article 	= Article::where('user_id','=',$id)->first();
    	if(isset($article->id))
    	{
    		// Fail
    		return 'Error. Pengguna ini memiliki artikel yang dalam situs/sub-situs. Hapus artikel atau Non-aktifkan pengguna ini';
    	}
    	else
    	{
    		// Success
    		$user->delete();
    		return 'Berhasil dihapus';
    	} // EOF if article->id
    }
}
