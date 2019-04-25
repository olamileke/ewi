<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable=['user_id', 'poem_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function poem()
    {
    	return $this->belongsTo('App\Poem');
    }
}
