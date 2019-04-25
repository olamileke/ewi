<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Poem;

use App\Rating;

class Poem extends Model
{

    public $avgrating;

	protected $fillable=['title','type_id','user_id','picture','content','slug'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function type()
    {
    	return $this->belongsTo('App\Type');
    }

    public function tags()
    {
    	return $this->belongsToMany('App\Tag');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    // GETTING A POEM'S RATINGS, EITHER THE ROUNDED DOWN VALUE OF EXACT VALUE

    public function getRating()
    {
        if($this->ratings()->avg('rating') > 0 )
        {
            return bcdiv($this->ratings()->avg('rating'), 1,1);
        }

        return 0;
    }

    public function getRoundedRating()
    {
        return bcdiv($this->ratings()->avg('rating'),1,0);
    }

    // GETTING THE TEXT WHETHER REVIEW/REVIEWS

    public function getNumReviewsText()
    {
        if($this->comments->count() == 1)
        {
            return 'review';
        }

        return 'reviews';

    }
}
