<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Action;

use App\Poem;

use App\OverlayImage;

use App\User;

use App\Http\Controllers\NotificationsController;

use Auth;

class UsersController extends Controller
{
    // FOLLOWING A FELLOW USER

    public function follow(Request $request)
    {
    	$user=Auth::user();

    	$user->followings()->attach($request->id);

    	Action::create([
    		'user_id'=>Auth::id(),
    		'action'=>'follow',
    		'follow_id'=>$request->id
    	]);

    	return $user->followings()->count();
    }


    // UNFOLLOWING A USER

    public function unfollow(Request $request)
    {
        $user=Auth::user();

        // $user->followings()->detach($request->id);

        DB::Table('followers')->where('follower_id', Auth::id())
                              ->where('leader_id', $request->id)
                              ->delete();

        // DELETING THE RECORD OF THE FOLLOW ACTION

        $action=Action::where('action','follow')
                        ->where('user_id',Auth::id())
                        ->where('follow_id', $request->id);

        $action->delete();

        return $user->followings()->count();        
    }

    // FETCHING USER INFO TO UNFOLLOW

    public function getUnfollowInfo(User $user)
    {
        return view('notifications.unfollow')->with('user', $user);
    }


    public function read(Request $request)
    {
        $slug=$request->slug;

        $poem=Poem::where('slug', $slug)->first();

        Action::create([
            'user_id'=>Auth::id(),
            'action'=>'read',
            'poem_id'=>$poem->id
        ]);
    }

    public function yourPoems()
    {
        $id=Auth::id();

        $poems=Poem::where('user_id', $id)->get();

        return view('you.poems')->with('poems', $poems);
    }


    // RENDERING THE USER'S PROFILE VIEW

    public function ProfilePage($name)
    {
        $fullname=ucwords(str_replace('-',' ', $name));

        $user=User::where('name', $fullname)->first();

        $propername=explode(' ', ucwords(str_replace('-', ' ', Auth::user()->name)),2)[1];

        $identifier=explode(' ', $user->name, 2)[1];

        if($identifier == $propername)
        {
            $identifier='You';
        }

        $notification=new NotificationsController();

        $actions=$notification->getActionsYouDid($user->id);

        // dd($propername);
        return view('profile.view')->with('identifier', $identifier)
                                   ->with('user', $user)
                                   ->with('actions', $actions);
    }


    // CHANGING THE USER'S OVERLAY IMAGE

    public function changeOverlay(Request $request)
    {
        $this->validate($request, [
            'overlay'=>'required|image'
        ]);

        $overlayimg=$request->overlay;

        // WHAT THE OVERLAY IMAGE BE NAMED 

        $overlayname=time().$overlayimg->getClientOriginalName();

        $overlayimg->move('Images/OverlayImages', $overlayname);

        $overlay=OverlayImage::where('user_id', Auth::id())->first();

        $overlay->image=asset('Images/OverlayImages/'.$overlayname);

        $overlay->save();

        echo asset('Images/OverlayImages/'.$overlayname);

    }
}
