<?php

namespace App\Logic\Image;

use Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Models\Gallery;
use App\Models\AumList;


class ImageRepository
{
    public function upload( $form_data )
    {

        $validator = Validator::make($form_data, Gallery::$rules, Gallery::$messages);

        if ($validator->fails()) {

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);

        }

        $gallery_category_id    = $form_data['gallery_category_id'];
        $photo                  = $form_data['file'];

        $aum_id     = Auth::user()->aum_list_id;
        $makepath   = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        if (!File::exists($makepath)) {
            $makeDir = File::makeDirectory($makepath, 0777, true, true);
        }

        // Process Image
        $originalName = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);

        $allowed_filename = "g" . substr(md5(microtime()),rand(0,26),10) . "." . $extension;
        $icon_name        = 'thumb-' . $allowed_filename;

        // original & icon image
        $uploadSuccess1 = $this->original( $photo, $allowed_filename );
        $uploadSuccess2 = $this->icon( $photo, $icon_name );

        if( !$uploadSuccess1 || !$uploadSuccess2 ) {

            return Response::json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500
            ], 500);

        }
        else {
            $aum          = AumList::find($aum_id);
            $sessionImage = new Gallery();
            $sessionImage->filename               = $allowed_filename;
            $sessionImage->gallery_category_id    = $gallery_category_id;
            $sessionImage->caption                = 'Galeri ' . $aum->name;
            $sessionImage->save();

            return Response::json([
                'filename' => $allowed_filename // Tambahan sendiri
            ], 200);

        }

        return Response::json([
            'error' => false,
            'code'  => 200,
            'filename' => $allowed_filename // Tambahan sendiri
        ], 200);

    }

    /**
     * Optimize Original Image
     */
    public function original( $photo, $filename )
    {
        $aum_id     = Auth::user()->aum_list_id;
        $path    = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            })
            ->save( $path . $filename );

        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename )
    {
        $aum_id     = Auth::user()->aum_list_id;
        $path    = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(100, 100)
            ->save( $path  . $filename );

        return $image;
    }

    /**
     * Delete Image From Session folder, based on server created filename
     */
    public function delete( $filename )
    {
        $aum_id     = Auth::user()->aum_list_id;
        $full_size_dir = $path    = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR);
        $icon_size_dir = $path    = public_path('files'.DIRECTORY_SEPARATOR.'galeri'.DIRECTORY_SEPARATOR.$aum_id.DIRECTORY_SEPARATOR.'thumb-');

        $sessionImage = Gallery::where('filename', '=', $filename)->first();

        if(empty($sessionImage))
        {
            return Response::json([
                'error' => true,
                'code'  => 400,
                'path_generate' => $full_size_dir,
                'filename' => $filename,
            ], 400);

        }

        $full_path1 = $full_size_dir . $sessionImage->filename;
        $full_path2 = $icon_size_dir . $sessionImage->filename;

        if ( File::exists( $full_path1 ) )
        {
            File::delete( $full_path1 );
        }

        if ( File::exists( $full_path2 ) )
        {
            File::delete( $full_path2 );
        }

        // Delete dari db
        if( !empty($sessionImage))
        {
            $sessionImage->delete();
        }

        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }
}