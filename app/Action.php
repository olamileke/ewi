<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable=['user_id', 'action', 'follow_id', 'poem_id', 'comment_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function follow()
    {
    	return $this->belongsTo('App\User', 'follow_id');
    }

    public function poem()
    {
    	return $this->belongsTo('App\Poem');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
