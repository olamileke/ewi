<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Poem;

use App\Comment;

use App\Like;

use App\Favourite;

use App\Rating;

use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','activation_token','is_activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function types()
    {
        return $this->belongsToMany('App\Type');
    }

    public function followings()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'leader_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'leader_id', 'follower_id')->withTimestamps();
    }

    public function poems()
    {
        return $this->hasMany('App\Poem');
    }

    public function favourites()
    {
        return $this->hasMany('App\Favourite');
    }

    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    public function overlayimage()
    {
        return $this->hasOne('App\OverlayImage');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    // CHECKING IF A USER HAS FAVOURITED A POEM

    public function checkFavourite($poem_id)
    {
        $favourites=Favourite::where('user_id', $this->id)->get();

        $id_array=[];

        foreach($favourites as $favourite)
        {
            array_push($id_array, $favourite->poem_id);
        }

        if(in_array($poem_id, $id_array))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // FUNCTION TO CHECK IF A USER HAS FOLLOWED ANOTHER USER

    public function checkFollowing($id)
    {   
        $followers=Auth::user()->followings()->get();

        foreach($followers as $follower)
        {
            if($id == $follower->id)
            {
                return true;
            }
        }

        return false;
    }

    public function checkPoem($id)
    {
        $poems=Poem::where('user_id', Auth::id())->get();

        foreach($poems as $poem)
        {
            if($poem->id == $id)
            {
                return true;
            }
        }

        return false;
    }

    // GETTING A USERS RATING'S OBJECT OF A PARTICULAR POEM

    public function getRating($id)
    {
        $rating=Rating::where('user_id', $this->id)
                       ->where('poem_id', $id)
                       ->first();

        return $rating;
    }

    // DETERMINING IF A USER HAS RATED A POEM

    public function hasRated($id)
    {
        $rating=Rating::where('user_id', Auth::id())
                       ->where('poem_id', $id)
                    ->first();

        if($rating)
        {
            return true;
        }

        return false;
    }

    // CHECKING IF THE USER HAS LIKED A COMMENT

    public function hasLiked($id)
    {
        $like=Like::where('user_id', Auth::id())
                   ->where('comment_id', $id)
                   ->first();

        if($like)
        {
            return true;
        }

        return false;
    }

    // RETURNING THE PROPER TEXT OF THE TYPE

    public function setTypeText()
    {
        if($this->types->count() - 2 === 1)
        {
            return 'and 1 other';
        }

        return ($this->types->count() - 2).' others';  
    }


    // RETURNING THE PROPERLY FORMATTED STRING TO USE AS PROFILE PAGE SLUG

    public function getNameSlug()
    {
        return strtolower(str_replace(' ','-', $this->name));
    }

    // GETTING THE CORRECT GRAMMAR WHETHER FOLLOWER OR FOLLOWERS

    public function getFollowerGrammar()
    {
        if($this->followers->count() == 1)
        {
            return 'follower';
        }

        return 'followers';
    }

    // CHECKING TO SEE IF A USER HAS FOLLOWED A TAG

    public function followedTag($tag_id)
    {
        $followedtags=Auth::user()->tags;

        $id_array=[];

        foreach($followedtags as $tag)
        {
            array_push($id_array, $tag->id);
        }

        if(in_array($tag_id, $id_array))
        {
            return true;
        }

        return false;
    }
}
