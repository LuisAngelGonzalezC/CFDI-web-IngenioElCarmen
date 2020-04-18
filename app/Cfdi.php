<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cfdi extends Model
{
	public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
