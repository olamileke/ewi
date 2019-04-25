<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable=['type'];

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    public function poems()
    {
    	return $this->hasMany('App\Poem');
    }
}
