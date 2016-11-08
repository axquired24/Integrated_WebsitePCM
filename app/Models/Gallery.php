<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
	// Aum List Detail
    public function galleryCategory()
    {
    	return $this->belongsTo(GalleryCategory::class);
    }
}
