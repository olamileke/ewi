<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Rating;

class Rating extends Model
{
    protected $fillable=['user_id', 'rating', 'poem_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
