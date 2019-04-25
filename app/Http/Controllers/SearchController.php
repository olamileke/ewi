<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Poem;

use App\Tag;

use App\SearchTerm;

use App\User;

use Auth;

use Session;

class SearchController extends Controller
{
  public function __construct()
  {
    return $this->middleware(['mustFollow', 'FirstTime']);
  }


	// RENDERING THE SEARCH VIEW

    public function index(Request $request)
    {    
    	$poems=Poem::where('title', 'LIKE', '%'.$request->q.'%')->orWhere('content', 'LIKE', '%'.$request->q.'%')->get();

    	$people=User::where('is_activated',1)->where('is_first_time',1)->where('name', 'LIKE', '%'.$request->q.'%')->get();

    	$tags=Tag::where('tag', 'LIKE', '%'.$request->q.'%')->get();

      $term=SearchTerm::where('searchterm', $request->q)->first();

      if($poems->count() > 0 || $tags->count() > 0)
      {
        if(!$term)
        {
           SearchTerm::create([
                'searchterm'=>$request->q
            ]);
        }
      }

      // GETTING THE SEARCH TERMS TO DISPLAY IN THE SIDEBAR

      $searchterms=SearchTerm::where('searchterm','!=',$request->q)->inRandomOrder()->take(5)->get();

      $followings=Auth::user()->followings()->get();

      $id_array=[];

      foreach($followings as $following)
      {
          array_push($id_array, $following->id);
      }

      $follows=User::where('is_activated',1)
                      ->where('is_first_time',1)
                      ->whereNotIn('id', $id_array)  
                      ->where('id','!=',Auth::id())                                  
                      ->take(5)
                      ->inRandomOrder()
                      ->get();

      return view('search.index')->with('poems', $poems)
      							  ->with('people', $people)
      							  ->with('tags', $tags)
                      ->with('searchterm', $request->q)
    							     ->with('searchterms', $searchterms)
                       ->with('follows', $follows);
    }
}
