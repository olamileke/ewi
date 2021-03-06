<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

	protected $fillable=['user_id', 'comment_id'];

    public function poem()
    {
    	return $this->belongsTo('App\Poem');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
