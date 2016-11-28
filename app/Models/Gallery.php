<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public static $rules = [
        'file' => 'required|mimes:png,gif,jpeg,jpg'
    ];

    public static $messages = [
        'file.mimes' => 'File tidak didukung. Require(png,jpg,jpeg)',
        'file.required' => 'File Gambar bermasalah. Coba gambar lain/ kompres gambar dengan benar (Cek: Resolusi maksimal lebar&tinggi 2000pixel, file maksimal 8mb)',
    ];
    
	// Aum List Detail
    public function galleryCategory()
    {
    	return $this->belongsTo(GalleryCategory::class);
    }
}
