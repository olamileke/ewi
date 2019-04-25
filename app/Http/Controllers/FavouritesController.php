<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Favourite;

use Auth;

class FavouritesController extends Controller
{
    public function favorite($poem_id)
    {
    	// FAVORITING A POEM

    	$favorite=Favourite::create([
    		'user_id'=>Auth::id(),
    		'poem_id'=>$post_id
    	]);
    }

    public function unfavorite($poem_id)
    {
    	// UNFAVORITING A POEM

    	$favorite=Favourite::where('user_id', Auth::id())->where('poem_id', $poem_id);

    	$favorite->delete();
    }
}
