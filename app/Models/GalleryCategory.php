<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
	// Aum List Detail
    public function aumList()
    {
    	return $this->belongsTo(AumList::class);
    }

	// Aum List Detail
    public function gallery()
    {
    	return $this->hasMany(Gallery::class);
    }    
}
