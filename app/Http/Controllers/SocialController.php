<?php

namespace App\Http\Controllers;

use SocialAuth;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    
    public function auth($provider)
    {
    	return SocialAuth::authorize($provider);
    }

    public function auth_callback($provider)
    {
    	SocialAuth::login($provider, function($user, $details) {

    		$user->name=$details->full_name;
    		$user->email=$details->email;
    		$user->avatar=$details->avatar;

    		$user->save();
    	});

    	return redirect('/');
    }
}
