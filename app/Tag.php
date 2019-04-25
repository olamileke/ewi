<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable=['tag'];

    public function poems()
    {
    	return $this->belongsToMany('App\Poem');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    // Getting the proper text of the poem

    public function getPoemText()
    {
    	if($this->poems()->count() == 1)
    	{
    		return 'poem';
    	}

    	return 'poems';
    }

    // Getting the proper text of the followers

    public function getFollowersText()
    {
    	if($this->users()->count() == 1)
    	{
    		return 'follower';
    	}

    	return 'followers';
    }
}
