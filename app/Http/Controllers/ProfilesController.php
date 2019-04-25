<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function create(Request $request)
    {	

    	$this->validate($request, [
    		'aboutme'=>'required'
    	]);

    	$user=Auth::user();

    	$user->about_me=$request->aboutme;

    	$user->types()->attach($request->types);

    	$user->is_first_time=1;

    	$user->save();

    	return redirect('/');

    }
}
