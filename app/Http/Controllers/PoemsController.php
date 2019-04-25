<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Session;

use App\Action;

use App\Type;

use App\Poem;

use App\Rating;

use App\Comment;

use App\Tag;

class PoemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       return $this->middleware(['mustFollow', 'FirstTime']);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('poems.create')->with('types', Type::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title'=>'required|max:255',
            'imagepath'=>'required',
            'tags'=>'required',
            'picture'=>'required|image',
            'type'=>'required',
            'content'=>'required'
        ]);

        $poem=Poem::create([
            'title'=>$request->title,
            'type_id'=>$request->type,
            'user_id'=>Auth::id(),
            'slug'=>str_slug($request->title),
            'picture'=>asset('Images/Poems/'.$request->imagepath),
            'content'=>$request->content
        ]);

        Action::create([
            'user_id'=>Auth::id(),
            'action'=>'write',
            'poem_id'=>$poem->id
        ]);

        $tagArray=[];

        foreach($request->tags as $t)
        {
            $tag=Tag::where('tag',$t)->first();

            if($tag)
            {
                $tag->number_of_posts=$tag->number_of_posts + 1;

                $tag->save();
                $tagz=$tag;
            }
            else
            {
                
               $tagz=Tag::create([
                    'tag'=>$t
                ]);
            }

           array_push($tagArray, $tagz->id);
        }

        $poem->tags()->attach($tagArray);

        Session::flash('success', 'Poem created successfully');

        return redirect()->back();
    }

    public function storeImage(Request $request)
    {
        if(isset($request->image))
        {
            $image=$request->image;

            $imagename=time().'.'.$image->getClientOriginalName();

            $imagename=str_replace(' ', '', $imagename);

            $image->move('Images/Poems', $imagename);

            echo $imagename;
        }
        else
        {
            echo 'none';
        }

    }

    // CHECKING IF THE USER HAS RATED THE POEM

    public function checkRated(Request $request)
    {
        $poem=Poem::where('slug', $request->slug)->first();

        $rating=Rating::where('user_id', Auth::id())
                      ->where('poem_id', $poem->id)
                      ->first();

        if($rating)
        {
            echo 'true';
        }
    }

    /// REVIEWING A POEM

    public function review(Request $request)
    {
        // RATING A POEM

        $this->validate($request, [
            'slug'=>'required',
            'comment'=>'required'
        ]);

        $poem=Poem::where('slug',$request->slug)->first();

        if($request->rating == 0)
        {
                $comment=Comment::create([
                'user_id'=>Auth::id(),
                'poem_id'=>$poem->id,
                'comment'=>$request->comment
            ]);

                 Action::create([
                'user_id'=>Auth::id(),
                'action'=>'comment',
                'poem_id'=>$poem->id,
                'comment_id'=>$comment->id
            ]);

        }
        else
        {
                $rating=Rating::create([

                    'user_id'=>Auth::id(),
                    'rating'=>$request->rating,
                    'poem_id'=>$poem->id
                ]);

                $comment=Comment::create([
                    'user_id'=>Auth::id(),
                    'poem_id'=>$poem->id,
                    'rating_id'=>$rating->id,
                    'comment'=>$request->comment
                ]);

                 Action::create([
                    'user_id'=>Auth::id(),
                    'action'=>'review',
                    'poem_id'=>$poem->id,
                    'comment_id'=>$comment->id
                ]);

        }

        return view('comments.comment')->with('comment', $comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $poem=Poem::where('slug',$slug)->first();

        $related_poems=Poem::where('type_id', $poem->type->id)
                            ->where('id','!=', $poem->id)
                            ->inRandomOrder()
                            ->take(4)
                            ->get();

        $your_rating=Rating::where('user_id', Auth::id())
                      ->where('poem_id', $poem->id)
                      ->first();

        $comment=Comment::take(1)->first();

        return view('poems.view')->with('poem', $poem)
                                 ->with('relatedpoems', $related_poems)
                                 ->with('your_rating', $your_rating)
                                 ->with('comment', $comment);    
    }


    // RETURNING MORE POSTS TO THE PAGE VIA AJAX

    public function fetchMore($get_num)
    {
        $followings=Auth::user()->followings()->get();

        $id_array=[];

        foreach($followings as $following)
        {
            array_push($id_array, $following->id);
        }

        $poems=Poem::whereIn('user_id', $id_array)
                     ->orderBy('created_at','desc')
                     ->paginate($get_num);

        return view('poems.poem')->with('poems', $poems);
    }

    // CHECKING IF MORE POEMS EXIST TO BE DISPLAYED

    public function checkMore($current_num)
    {
         $followings=Auth::user()->followings()->get();

         if($followings->count() > $current_num)
         {
             echo true;
         }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
