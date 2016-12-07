<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use App\Logic\Image\ImageRepository;
use Illuminate\Support\Facades\Input;

class ImageController extends Controller
{
    protected $image;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;
    }

    // public function getUpload()
    // {
    //     return view('dropzone.uploadfile');
    // }

    public function postUpload()
    {
        $photo = Input::all();
        $response = $this->image->upload($photo);
        return $response;

    }

    public function deleteUpload()
    {

        $filename = Input::get('id');

        if(!$filename)
        {
            return 0;
        }

        $response = $this->image->delete( $filename );

        return $response;
    }

    // public function deleteFromEdit($product_id, $image_filename)
    // {

    //     $filename = $image_filename;

    //     if(!$filename)
    //     {
    //         return 0;
    //     }

    //     $response = $this->image->delete( $filename );

    //     return Redirect::to('admin/product/image/edit/'.$product_id);
    // }    
}
