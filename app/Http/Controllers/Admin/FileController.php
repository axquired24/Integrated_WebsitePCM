<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File as File;
use Auth;
use Datatables;
use DB;
use Redirect;
use App\Models\File as FileUpload;

class FileController extends Controller
{
    public function index()
    {
    	return view('admin.file.list');
    }

    public function indexData(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	// Just to display mysql num rows, add this code
		DB::statement(DB::raw('set @rownum=0'));
		$table 	= FileUpload::select([DB::raw('@rownum := @rownum + 1 AS rownum'),
					'files.*',
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
	    		->editColumn('title', function($table){
	    			return $table->title . ' <br><small>( File: '. $table->filename .')</small>';
	    		})
	    		->addColumn('action', function($table){
	    			return
	    			'<a title="hapus" href="javascript:" onclick="deleteBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-danger"><span class="fa fa-trash-o"></span></a>
	    				<a title="Ubah judul file" href="javascript:" onclick="editBtn('.$table->id.', \''.$table->title.'\')" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
	    				';
	    		})
	    		->make(true);
    }

    public function add()
    {
    	return view('admin.file.add');
    }

    public function addPost(Request $request)
    {
    	$aum_id 	= Auth::user()->aum_list_id;
    	if ($request->file('file')->isValid()) {
	    	$file = $request->file('file');
	    	$title = $request['title'];

	    	// Processing File
	    	$extension = $file->getClientOriginalExtension();
			$allowed_filename = "f" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
	    	$destinationPath 	= public_path('files'.DIRECTORY_SEPARATOR.'lain'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
	    	$request->file('file')->move($destinationPath, $allowed_filename);

	    	$fileUp 	= new FileUpload();
	    	$fileUp->title = $title;
	    	$fileUp->aum_list_id = $aum_id;
	    	$fileUp->filename = $allowed_filename;

	    	$fileUp->save();

	    	return Redirect::to('admin/file');
		} // EOF if
		return Redirect::to('admin/file'); // else
    }

    public function editPost(Request $request)
    {
    	$id 	= $request['id'];
    	$title 	= $request['title'];

    	$fileUp 	= FileUpload::find($id);
    	$fileUp->title 	= $title;
    	$fileUp->save();

    	return 'Judul file berhasil diubah. ('. $title .')';
    }

    public function deletePost(Request $request)
    {
    	$id 		= $request['id'];
    	$fileUp 	= FileUpload::find($id);
    	$filename 	= $fileUp->filename;
    	$title 		= $fileUp->title;

    	// Deleting file from dir
    	$aum_id 	= Auth::user()->aum_list_id;
    	$path 		= public_path('files'.DIRECTORY_SEPARATOR.'lain'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
    	$full_path 	= $path . $filename;
    	// Delete if any file
        if ( File::exists( $full_path ) )
        {
            File::delete( $full_path );
        } // EOF If
        
        $fileUp->delete();

        return 'File '.$title.' berhasil dihapus.';
    }
}
