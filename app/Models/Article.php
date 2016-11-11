<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	// Article Category
    public function articleCategory()
    {
    	return $this->belongsTo(ArticleCategory::class);
    }

    // Post by User
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
