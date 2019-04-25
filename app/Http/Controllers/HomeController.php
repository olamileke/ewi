<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Type;

use App\User;

use App\Poem;

use App\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(!Auth::check())
       {
            return view('home.index');
       }  
       else
       {
            if(Auth::user()->is_first_time)
            {

                $followings=Auth::user()->followings()->get();

                if($followings->count() > 0)
                {
                    $id_array=[];

                    foreach($followings as $following)
                    {
                        array_push($id_array, $following->id);
                    }

                    $poems=Poem::whereIn('user_id', $id_array)->orderBy('created_at','desc')->take(4)->get();

                    $poemcount=Poem::whereIn('user_id', $id_array)->orderBy('created_at','desc')->get()->count();

                    $tags=Tag::inRandomOrder()->take(5)->get();

                    array_push($id_array, Auth::id());

                    $follows=User::where('is_activated',1)
                                    ->where('is_first_time',1)
                                    ->whereNotIn('id', $id_array)                                    
                                    ->take(5)
                                    ->inRandomOrder()
                                    ->get();

                    return view('home.loggedin')->with('poems', $poems)
                                                 ->with('poem_count', $poemcount)
                                                 ->with('tags', $tags)
                                                 ->with('follows', $follows); 
                }
                else
                {
                    $follows=User::inRandomOrder()
                                  ->where('is_first_time',1)
                                  ->where('id','!=',Auth::id())
                                  ->take(12)->get();
                    return view('home.loggedin')->with('follows', $follows);
                }
            }
            else
            {
                return view('profile.create')->with('types', Type::all());
            }
       }  

    }
}
