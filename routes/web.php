<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('/signup', function() {
	return view('home.signup');
});


Route::get('/logout', function() {
	Auth::logout();
	return redirect('/login');
});

Route::get('/{provider}/auth', 'SocialController@auth')->name('social.auth');

Route::get('/{provider}/redirect', 'SocialController@auth_callback')->name('social.callback');

Route::get('/account/activate/{token}', 'AccountsController@activate')->name('account.activate');

Auth::routes();

Route::post('/profile/complete', 'ProfilesController@create')->name('profile.create');

Route::post('/user/follow', 'UsersController@follow')->name('user.follow');

Route::post('/user/unfollow', 'UsersController@unfollow')->name('user.unfollow');

Route::post('/user/getunfollowinfo/{user}', 'UsersController@getUnfollowInfo');

Route::post('/user/read', 'UsersController@read')->name('user.read');

// GROUPED POEM ROUTES IN THE APPLICATION

Route::group(['prefix'=>'poem', 'middleware'=>'auth'], function() {

	Route::get('/create', 'PoemsController@create')->name('poem.create');

	Route::post('/store', 'PoemsController@store')->name('poem.store');

	Route::get('/{slug}', 'PoemsController@show')->name('poem.show');

	Route::post('/review', 'PoemsController@review')->name('poem.review');

	Route::post('/checkrated', 'PoemsController@checkRated');

	Route::get('/fetchmore/{get_num}', 'PoemsController@fetchMore');

	Route::post('/checkmore/{current_num}', 'PoemsController@checkMore');
});


// GROUPED TYPE ROUTES IN THE APPLICATION

Route::group(['prefix'=>'type', 'middleware'=>'auth'], function() {

	Route::get('/{type}','TypesController@show')->name('type');

	Route::post('/fetchmore/{get_num}','TypesController@fetchMore');
});

Route::post('/poem/picture/upload', 'PoemsController@storeImage');

Route::get('/tag/{tag}', 'TagsController@show')->name('tag.show');

Route::post('/tag/fetchmorepoems/{tag}/{get_num}', 'TagsController@fetchMorePoems');

// FOLLOW A TAG

Route::post('/tag/follow/{id}', 'TagsController@follow');

// UNFOLLOWING A TAG

Route::post('/tag/unfollow/{id}', 'TagsController@unFollow');

// THE USER VIEWING HIS TAGS

Route::get('/user/tags/{name}', 'TagsController@view')->name('tag.view')->middleware('TagRestriction');

// TAGS BEING ORDERED

Route::group(['prefix'=>'tag'], function() {

	Route::post('/order/alphabet', 'TagsController@orderByAlphabet');

	Route::post('/order/number', 'TagsController@orderByPoemNumbers');

	Route::post('/order/latest', 'TagsController@orderLatest');

	Route::post('/fetchinfo/{tag}', 'TagsController@fetchInfo');

	Route::post('/unfollow/{id}', 'TagsController@unFollow');

}); 


Route::post('/favorite/{poem_id}', 'FavouritesController@favorite')->name('favourite');

Route::post('/unfavorite/{poem_id}', 'FavouritesController@unfavorite')->name('unfavourite');

Route::get('/notifications', 'NotificationsController@index');

Route::post('/comment/like', 'CommentsController@like');

Route::post('/comment/unlike', 'CommentsController@unlike');


Route::post('comments/fetchMore/{slug}/{get_num}', 'CommentsController@fetchMore');


Route::get('/you/poems','UsersController@yourPoems')->name('you.poems');


Route::post('/notifs/followings/{get_num}/{page}', 'NotificationsController@fetchMoreFollowings');

Route::post('/notifs/you/{get_num}', 'NotificationsController@fetchMoreYourActions');


Route::post('/action/getdetail/{id}', 'ActionsController@getDetail');

Route::post('/comment/display/{c_id}', 'CommentsController@display');

Route::post('/comment/reply', 'CommentsController@reply');


// SEARCH ROUTE

Route::get('/search', 'SearchController@index');


// PROFILE PAGE

Route::get('/user/{name}', 'UsersController@ProfilePage')->name('profile');

// POST ROUTE TO TO CHANGE THE OVERLAY IMAGE

Route::post('/user/overlay/change', 'UsersController@changeOverlay');

// ROUTE FOR THE EXPLORE VIEW

Route::get('/explore', 'ExploreController@index');

Route::post('/explore/getrated', 'ExploreController@getHighestRated');

Route::post('/explore/getlatest', 'ExploreController@getLatest');

Route::post('/explore/getbyengagement', 'ExploreController@getByEngagement');


