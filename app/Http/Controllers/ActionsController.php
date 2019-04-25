<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Action;

use App\Poem;

use App\Comment;

class ActionsController extends Controller
{
    public function getDetail($id)
    {
    	$action=Action::find($id);

    	return view('actions.completeview')->with('action', $action);

    }
}
