<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
	// Aum List Detail
    public function aumList()
    {
    	return $this->belongsTo(AumList::class);
    }

    // Article All
    public function article()
    {
    	return $this->hasMany(Article::class);
    }    
}
