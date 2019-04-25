<?php

namespace App\Http\Controllers;

use Auth;

use App\User;

use App\Token;

use App\OverlayImage;

use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function activate($token)
    {

    	$tokenz=new Token($token);

    	$hash_token=$tokenz->getHash();

    	$user=User::where('activation_token', $hash_token)->first();

    	if($user)
    	{
            OverlayImage::create([
                'image'=>asset('Images/OverlayImages/defaultpoetryoverlay.jpg'),
                'user_id'=>$user->id
            ]);

    		$user->activation_token=null;

    		$user->is_activated=1; 

    		$user->save();

    		Auth::login($user);
    	}

    	return redirect('/');
    }
}
