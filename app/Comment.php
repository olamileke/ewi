<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['user_id', 'poem_id', 'rating_id' ,'comment'];

    public function poem()
    {
    	return $this->belongsTo('App\Poem');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function rating()
    {
    	return $this->belongsTo('App\Rating');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
