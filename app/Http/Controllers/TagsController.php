<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Tag;

use App\Poem;

use Carbon\Carbon;

use Auth;

class TagsController extends Controller
{
    public function __construct()
    {
       return $this->middleware(['mustFollow', 'FirstTime']);        
    }

    // RENDERING THE INDIVIDUAL TAG VIEW

    public function show($tag)
    {
    	$tag=Tag::where('tag', $tag)->first();

    	$id_array=[];

    	foreach($tag->poems as $poem)
    	{
    		array_push($id_array, $poem->id);
    	}

    	$poems=Poem::whereIn('id', $id_array)->orderBy('created_at', 'desc')->take(8)->get();

        $follows=$tag->users->where('id','!=',Auth::id())->take(5);

    	return view('tag.show')->with('tag', $tag)
                               ->with('poems', $poems)
    						   ->with('follows', $follows);
    }

    // FETCHING MORE POEMS ON THE TAG VIEW VIA AJAX

    public function fetchMorePoems($tag,$get_num)
    {
    	$tag=Tag::where('tag', $tag)->first();

    	$id_array=[];

    	foreach($tag->poems as $poem)
    	{
    		array_push($id_array, $poem->id);
    	}

    	$poems=Poem::whereIn('id', $id_array)->orderBy('created_at', 'desc')->paginate($get_num);

    	return view('poems.poem')->with('poems', $poems);
    }


    // FOLLOWING A TAG

    public function follow($id)
    {
        $user=Auth::user();

        $user->tags()->attach($id);

        return Tag::find($id)->users()->count();
    }

    // UNFOLLOWING A TAG

    public function unFollow($id)
    {
        DB::Table('tag_user')->where('tag_id', $id)
                             ->where('user_id', Auth::id())
                             ->delete();

        return Tag::find($id)->users->count();
    }

    // THE LOGGED IN USER VIEWING HIS TAGS

    public function view($name)
    {
        $tags=DB::Table('tag_user')->where('user_id', Auth::id())
                                   ->join('tags', 'tag_user.tag_id', '=', 'tags.id')
                                   ->select('tags.id','tag_user.tag_id','tags.tag','tag_user.created_at','tags.number_of_posts')
                                   ->orderBy('tag_user.created_at', 'desc')
                                   ->get();

        $id_array=$this->setTagDates($tags);

        $followtags=Tag::whereNotIn('id', $id_array)
                        ->inRandomOrder()
                        ->take(5)
                        ->get();

        return view('tag.view')->with('tags', $tags)
                               ->with('followtags', $followtags);
    }

    public function setTagDates($tags)
    {
        $array=[];

        foreach($tags as $tag)
        {
            $tag->created_at=Carbon::parse($tag->created_at)->diffForHumans();

            array_push($array, $tag->id);
        }

        return  $array;
    }


    // RETURNING TAGS ACCORDING TO WHEN YOU FOLLOWED THEM

    public function orderLatest()
    {
        $tags=DB::Table('tag_user')->where('user_id', Auth::id())
                                   ->join('tags', 'tag_user.tag_id', '=', 'tags.id')
                                   ->select('tags.id','tag_user.tag_id','tags.tag','tag_user.created_at','tags.number_of_posts')
                                   ->orderBy('tag_user.created_at', 'desc')
                                   ->get();

        $this->setTagDates($tags);

        return view('tag.tag')->with('tags', $tags);

    }


    // RETURNING TAGS ORDERED ALPHABETICALLY

    public function orderByAlphabet()
    {
        $tags=DB::Table('tag_user')->where('user_id', Auth::id())
                                   ->join('tags', 'tag_user.tag_id', '=', 'tags.id')
                                   ->orderBy('tags.tag', 'asc')
                                    ->select('tags.id','tag_user.tag_id','tags.tag','tag_user.created_at','tags.number_of_posts')
                                   ->get();

        $this->setTagDates($tags);

        return view('tag.tag')->with('tags', $tags);
    }

    // RETURNING POEMS ORDERED BY THEIR NUMBER OF POEMS

    public function orderByPoemNumbers()
    {
        $tags=DB::Table('tag_user')->where('user_id', Auth::id())
                                   ->join('tags', 'tag_user.tag_id', '=', 'tags.id')
                                   ->orderBy('tags.number_of_posts', 'desc')
                                    ->select('tags.id','tag_user.tag_id','tags.tag','tag_user.created_at','tags.number_of_posts')
                                   ->get();


        $this->setTagDates($tags);

        return view('tag.tag')->with('tags', $tags);
    }


    // RETURNING THE TAG INFORMATION TO UNFOLLOW

    public function fetchInfo(Tag $tag)
    {
        return view('tag.unfollow')->with('tag', $tag);
    }
}
