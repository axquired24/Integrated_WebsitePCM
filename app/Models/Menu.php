<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // Aum List Detail
    public function aumList()
    {
    	return $this->belongsTo(AumList::class);
    }
}
