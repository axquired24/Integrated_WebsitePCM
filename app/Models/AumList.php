<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AumList extends Model
{
	// Article Category
    public function articleCategory()
    {
    	return $this->hasMany(ArticleCategory::class);
    }

	// User
    public function user()
    {
    	return $this->hasMany(User::class);
    }

	// Pages
    public function page()
    {
    	return $this->hasMany(Page::class);
    }

	// GalleryCategory
    public function galleryCategory()
    {
    	return $this->hasMany(GalleryCategory::class);
    }

	// Files
    public function file()
    {
    	return $this->hasMany(File::class);
    }     
}
