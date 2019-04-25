<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Action;

use App\User;

use App\Poem;

use App\Comment;

use Auth;

class NotificationsController extends Controller
{

    public function __construct()
    {
       return $this->middleware(['mustFollow', 'FirstTime']);
    }


    // RENDERING THE NOTIFICATIONS PAGE VIEW

    public function index()
    {
        $actions=$this->getFollowActions();

        $actions=$actions->merge($this->getPoemActions())->merge($this->getCommentActions());

        $followingscount=$actions->count();

        $actions=$actions->sortByDesc('created_at')->take(10);

        $user=User::find(2);


        $youractions=$this->getYourActions()->get();

    	return view('notifications.show')->with('actions', $actions)->with('your_actions', $youractions)
            ->with('followingscount', $followingscount)
            ->with('youractionscount', $youractions->count())
            ->with('user', $user);
    }


    // RETURNING ACTIONS THAT YOU CARRIED OUT

    public function getActionsYouDid($id)
    {
        $actions=Action::where('user_id', $id)
                       ->orderBy('created_at', 'desc')
                       ->take(5)
                       ->get();

        return $actions;
    }


    // RETURNING ACTIONS CARRIED OUT ON YOUR POEMS OR COMMENTS OR IF YOU WERE FOLLOWED

    public function getYourActions()
    {
        $actions=Action::where('follow_id', Auth::id())
                            ->orWhereIn('poem_id', $this->getPoemArray())->where('action','!=', 'write')
                            ->orWhereIn('comment_id', $this->getCommentArray())->where('user_id','!=',Auth::id())
                            ->orderBy('created_at','desc');

        return $actions;
    }

    // THIS RETURNS THE ID OF EVERY USER THAT THE CURRENTLY LOGGED IN USER IS FOLLOWING IN AN ARRAY

    public function getFollowingsIDArray()
    {
        $followings=Auth::user()->followings()->get();

        $id_array=[];

        foreach($followings as $following)
        {
            array_push($id_array, $following->id);
        }

        return $id_array;
    }


    // PEOPLE YOU FOLLOW WHEN THEY FOLLOW OTHER PEOPLE

    public function getFollowActions()
    {
        $followactions=Action::whereIn('user_id', $this->getFollowingsIDArray())       
                              ->where('action','follow')             
                              ->where('follow_id', '!=',Auth::id())
                              ->get();

        return $followactions;

    }


    // RETURNING AN ARRAY OF THE CURRENTLY LOGGED IN USER'S POEMS ID

    public function getPoemArray()
    {
        $yourpoems=Poem::where('user_id', Auth::id())->get();

        $poem_array=[];

        foreach($yourpoems as $poem)
        {
            array_push($poem_array, $poem->id);
        }

        return $poem_array;

    }

    // RETURNING AN ARRAY OF THE CURRENT LOGGED IN USERS COMMENTS IDs

    public function getCommentArray()
    {
        $yourcomments=Comment::where('user_id', Auth::id())->get();

        $com_array=[];

        foreach($yourcomments as $comment)
        {
            array_push($com_array, $comment->id);
        }

        return $com_array;
    }

    // PEOPLE YOU FOLLOW WHEN THEY DO STUFF RELATING TO POEMS E.G WRITE, READ, REVIEW

    public function getPoemActions()
    {
         $poemactions=Action::whereIn('user_id', $this->getFollowingsIDArray())                            
                            ->whereNotIn('poem_id',$this->getPoemArray())
                            ->get();

         return $poemactions;
    }

    // PEOPLE YOU FOLLOW WHEN THEY LIKE PEOPLE'S COMMENTS

    public function getCommentActions()
    {
         $commentactions=Action::whereIn('user_id', $this->getFollowingsIDArray())
                                ->where('action', 'like')
                                ->whereNotIn('comment_id', $this->getCommentArray())
                                ->get();

        return $commentactions;
    }


    // RETURNING MORE ACTIONS BY PEOPLE YOU FOLLOW TO THE VIEW

    public function fetchMoreFollowings($get_num, $page)
    {
        $actions=$this->getFollowActions();

        $actions=$actions->merge($this->getPoemActions())->merge($this->getCommentActions());

        $actions=$actions->sortByDesc('created_at')->slice($get_num * $page)->take(10);

        return view('actions.action')->with('actions',$actions);
    }

    // RETURNING MORE ACTIONS PERFORMED ON YOU, YOUR POEMS OR YOUR COMMENTS

    public function fetchMoreYourActions($get_num)
    {
        $actions=$this->getYourActions()->paginate($get_num);

        return view('actions.action')->with('actions', $actions);
    }
}
