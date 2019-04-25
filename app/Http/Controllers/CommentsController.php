<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;

use App\Like;

use App\Action;

use App\Poem;

use App\Reply;

use Auth;

class CommentsController extends Controller
{
	// LIKING A COMMENT

    public function like(Request $request)
    {
    	$comment=Comment::find($request->comment_id);

    	Like::create([
    		'user_id'=>Auth::id(),
    		'comment_id'=>$request->comment_id
    	]);

    	Action::create([
    		'user_id'=>Auth::id(),
    		'action'=>'Like',
    		'comment_id'=>$comment->id
    	]);

    	echo $comment->likes->count();
    }

    // UNLIKING A COMMENT

    public function unlike(Request $request)
    {
    	$comment=Comment::find($request->comment_id);

    	$like=Like::where('user_id', Auth::id())
    			  ->where('comment_id', $request->comment_id)
    			  ->first();

    	$like->delete();

        Action::where('action','Like')
              ->where('user_id', Auth::id())
              ->where('comment_id', $request->comment_id)
              ->delete();

    	echo $comment->likes->count();
    }

    // LOADING MORE COMMENTS INTO THE PAGE VIA AJAX

    public function fetchMore($slug, $get_num)
    {
        $poem=Poem::where('slug', $slug)->first();

        $comments=Comment::where('poem_id', $poem->id)->paginate($get_num);

        echo view('comments.comments')->with('comments',$comments);
    }

    /// DISPLAYING A COMMENT FOR REPLY ON THE POEM VIEW PAGE

    public function display($c_id)
    {
        $comment=Comment::find($c_id);

        return view('comments.replytemplate')->with('comment', $comment);
    }


    // REPLYING TO A COMMENT

    public function reply(Request $request)
    {
        $this->validate($request, [
            'reply'=>'required',
            'id'=>'required'
        ]);

        $reply=Reply::create([
            'user_id'=>Auth::id(),
            'reply'=>$request->reply,
            'comment_id'=>$request->id
        ]);

        return view('comments.reply')->with('reply', $reply);      


    }
}
