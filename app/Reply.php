<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable=['user_id', 'reply', 'comment_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
