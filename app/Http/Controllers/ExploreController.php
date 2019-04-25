<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Poem;

use App\User;

use Auth;

class ExploreController extends Controller
{
	// RENDERING THE INITIAL EXPLORE VIEW

    public function index()
    {   
    	$follows=User::whereNotIn('id', $this->getFollowingIDs())
    				 ->inRandomOrder()
    				 ->take(5)
    				 ->get();

    	return view('explore.index')
    			->with('latestpoems', $this->getLatestPoems())
    			->with('follows', $follows);
    }

    // FETCHING THE LATEST POEMS

    public function getLatestPoems()
    {
    	$latestpoems=Poem::whereNotIn('user_id', $this->getFollowingIDs())
    					  ->orderBy('created_at', 'desc')
    					  ->take(10)
    					  ->get();
    	return $latestpoems;
    }

    // FETCHING THE IDS OF USERS THE LOGGED IN USER IS FOLLOWING IN AN ARRAY

    public function getFollowingIDs()
    {
    	$followings=Auth::user()->followings()->get();

    	$id_array=[];

    	foreach($followings as $user)
    	{
    		array_push($id_array, $user->id);
    	}

    	return $id_array;
    }

    // RETURNING THE POSTS SORTED BY THEIR RATINGS DESC

    public function getHighestRated()
    {

    	$poems=Poem::whereNotIn('user_id', $this->getFollowingIDs())
    				->inRandomOrder()
    				->take(10)
    				->get();

    	foreach($poems as $poem)
    	{
    		$poem->avgrating=$poem->ratings()->avg('rating');
    	}

    	$poems=$poems->sortByDesc('avgrating');

    	return view('poems.poem')->with('poems', $poems);
    }

    // RETURNING THE LATEST POEMS

    public function getLatest()
    {
    	return view('poems.poem')->with('poems', $this->getLatestPoems());
    }


    // RETURNING THE POEMS SORTED BY THEIR LEVEL OF USER ENGAGEMENT

    public function getByEngagement()
    {
    	$poems=$this->getLatestPoems();  

    	foreach($poems as $poem)
    	{
    		$poem->engage_score=0;

    		$poem->engage_score+=$poem->comments->count() * 3;

    		foreach($poem->comments as $comment)
    		{
    			$poem->engage_score+=$comment->replies->count() * 2;
    			$poem->engage_score+=$comment->likes->count();
    		}
    	}

    	$poems=$poems->sortByDesc('engage_score');

    	return view('poems.poem')->with('poems', $poems);
    }


}
