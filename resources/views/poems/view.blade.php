@extends('layouts.app')

@section('page_title')

	{{ $poem->title }}
@endsection()

@section('page_css')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/Poems/view.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/Poems/reply.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/info.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css\notifications\unfollow.css') }}">	
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">


	<!-- EXTERNAL CSS FOR THE MODAL -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css">

	<!-- CSRF TOKEN TO SEND ALONG WITH AJAX CALLS -->

	<meta name='csrf-token' content="{{ csrf_token() }}">
@endsection()


@section('page_body')

	<div class='unfollowcontainer' hidden>	
			
		<div class='dialog'>	
			<div class='img'>
				<img src="{{ asset($poem->user->avatar) }}">
			</div>

			<p>Are you sure you want to unfollow {{ $poem->user->name }}?</p>

			<div class='buttons'>
				<button class='unfollow'>Unfollow</button>
				<button class='close'>Close</button>
			</div>
		</div>

	</div>

	<div class='container'>
		
		<div class='details'>
			
			<div class='metadata'>
				
				<p class='title'>{{ $poem->title }}</p>

				<div class='user'>
					<img src="{{$poem->user->avatar}}">
					<p>
						<a href="{{ route('profile', ['name'=>$poem->user->getNameSlug()]) }}">{{ $poem->user->name }}</a>
					</p>
				</div>

				<div class='type'>
					<a href="{{ route('type', ['type'=>strtolower($poem->type->type)]) }}">
						{{ $poem->type->type }}
					</a>					
					<span> <i class='fas fa-star'></i> {{ $poem->getRating(true) }}</span>
				</div>

				<p class='time'>
					{{ $poem->created_at->toFormattedDateString() }}
				</p>

				<div class='actions'>
					<button>Download</button>
					<button>Listen</button>

					@if(Auth::id() != $poem->user->id)

						<span hidden>{{ $poem->id }}</span>

						@if(Auth::user()->checkFavourite($poem->id))

							<button class='favorite'>Unfavorite <i class='fas fa-star'></i></button>
						@else

							<button class='favorite'>Favorite <i class='far fa-star'></i></button>
						@endif

					@endif()
				</div>
			</div>

			<div class='picture'>
				
				<img src="{{ asset($poem->picture) }}">
			</div>
		</div>

		<p class='content'>
			{{ $poem->content }}
		</p>


		<p>Tags</p>
		<div class='tagscontainer'>
			
			@foreach($poem->tags as $tag)

				<div class='tag'>
					
					<a href='{{ route("tag.show", ["tag"=>strtolower($tag->tag)]) }}'> {{ $tag->tag }}
					</a>
				</div>
			
			@endforeach
		</div>

		<div class='author'>
			
			<img src="{{ asset($poem->user->avatar) }}">
			<div>

				<p>
					<a href="{{ route('profile', ['name'=>$poem->user->getNameSlug()]) }}">
						{{ $poem->user->name }}
					</a>
				</p>

				<p>{{ $poem->user->about_me }}</p>

				<span class='author-id' hidden>{{ $poem->user->id }}</span>

				@if(!Auth::user()->checkFollowing($poem->user->id))

					@if(Auth::id() != $poem->user->id)

						<button class='follow'>Follow</button>

					@endif()

				@else

					<li class='unfollow-dialog'>Following</li>
				@endif
			</div>
		</div>

		<div class='rated'>
			
			@if($your_rating)

				<div>
					@for($i= 1; $i<= $your_rating->rating; $i++)

						<i class='fas fa-star rate'></i>
					@endfor

					@for($i=1; $i<= 5 - $your_rating->rating; $i++)

						<i class='far fa-star rate'></i>
					@endfor()
				</div>

				<p>You rated this {{ $your_rating->created_at->diffForHumans() }}</p>

			@endif()
			
		</div>


		@if(Auth::id() != $poem->user->id)
			<div class='review'>
				 <a href="#review" rel='modal:open'>

				 	@if($poem->comments->count() == 0)
					 	Be the first to Review
					@else
					 	Review
					@endif
				</a> 
			</div>
		@endif

		<div class='commentscontainer'>
			<span class='total_comments' hidden>
				{{ $poem->comments->count() }}
			</span>
			
			<div class='no_of_comments'>{{ $poem->comments->count() }} {{ $poem->getNumReviewsText() }}</div>
			<p></p>

			@foreach($poem->comments->take(10) as $comment)

				<div class='comment'>

					<span class='time'>
						{{$comment->created_at->diffForHumans() }}
					</span>
					<div class='commentdetails'>
						<img src="{{ $comment->user->avatar }}" width='35px' height='35px'>
						<p>
							<span>
							@if($comment->rating)

								@if(Auth::id() == $comment->user->id)

									You

								@else

									{{ $comment->user->name }}

								@endif 

								 reviewed 
								</span>

								<span>
									@for($i= 1; $i<= $comment->rating->rating; $i++)

										<i class='fas fa-star rate'></i>
									@endfor

									@for($i=1; $i<= 5 - $comment->rating->rating; $i++)

										<i class='far fa-star rate'></i>
									@endfor()
								</span>

							@else

								<p>{{ $comment->user->name }} commented 

							@endif()
						</p>
					</div>
					<div class='commentbody'>
						{{$comment->comment}}
					</div>
					<div>
						@if(Auth::user()->hasLiked($comment->id))

							<i class='fas fa-heart'></i>
						@else
							<i class='far fa-heart'></i>
						@endif()

						<i class='id' hidden>{{ $comment->id }}</i>
						<span class='likes-count'>{{ $comment->likes->count()}}</span>

						@if($comment->user->id != Auth::id())
							<span class='comment_id' hidden>{{ $comment->id }}</span>
							<button class='replybtn'>Reply</button>

						@endif
					</div>

					<div class='replycontainer'>

						@foreach($comment->replies as $reply)
							<div class='reply'>
								<div>
									<img src="{{ asset($reply->user->avatar) }}">

									<p class='detail'>

										@if($reply->user->id == Auth::id())

											You
										@else

											{{ $reply->user->name }}
										@endif
										 replied {{ $reply->created_at->diffForHumans() }}
									</p>
								</div>

								<p class='reply'>
									{{ $reply->reply }}
								</p>
							</div>
						@endforeach()

					</div>					
				</div>
			@endforeach()
		</div>

		@if($poem->comments->count() > 10)
			<button class='more'>Load More </button>
		@endif
	</div>

	<div id='review' class='modal'>

		<div class='container'>
			
				@if(Auth::user()->hasRated($poem->id))

					@if(Auth::user()->getRating($poem->id)->rating > 1)

						<p>You rated this Poem {{ Auth::user()->getRating($poem->id)->rating }} stars! </p>
					@else	

						<p>You rated this Poem {{ Auth::user()->getRating($poem->id)->rating }} star! </p>
					@endif

					<div class='rate'>
						@for($i=1; $i <= $poem->getRating(); $i++)

							<i class='fas fa-star'></i>

						@endfor()

						@for($i=1; $i <= 5 - $poem->getRating(); $i++)

							<i class='far fa-star'></i>
							
						@endfor()

					</div>
				@else
					<p>Rate This Poem (optional)</p>

					<div class='rate'>

						<i class='far fa-star'></i>
						<i class='far fa-star'></i>
						<i class='far fa-star'></i>
						<i class='far fa-star'></i>
						<i class='far fa-star'></i>

					</div>
				@endif
		
			

			<div class='comment'>
				<textarea autofocus></textarea>
				<button>Review</button>
			</div>
			<a href="#" rel='modal:close'></a>
		</div>
	</div>

	<div class='related_poems'>

		@foreach($relatedpoems as $poem)

			<div class='poem'>
				
				<div class='picture'>
					<img src="{{ asset($poem->picture) }}">
				</div>

				<div class='content'>
					<p class='title'>{{ $poem->title }}</p>
					<p>
						<img src="{{ asset($poem->user->avatar) }}" width='30px' height='30px'>
						 <span> 
						 	<a href="{{ route('profile', ['slug'=>$poem->user->getNameSlug()]) }}">{{ $poem->user->name }}</a>
						</span>
					</p>
					<p>
						<a href="{{ route('type', ['slug'=>strtolower($poem->type->type)]) }}">{{ $poem->type->type }}</a>
					</p>

					<div class='ratings'>
						@for($i=1; $i <= $poem->getRating(); $i++)

							<i class='fas fa-star'></i>

						@endfor()

						@for($i=1; $i <= 5 - $poem->getRating(); $i++)

							<i class='far fa-star'></i>
							
						@endfor()

						<span class='ratingval'>{{ $poem->getRating(true) }} avg. rating </span>
					</div>

					<a href="{{ route('poem.show', ['slug'=>$poem->slug]) }}" class='read'>Read</a>

				</div>
			</div>
		@endforeach()
	</div>

	<div class='reply_background' hidden>
		
			
			<div class='reply_container'>				
				
				
			</div>			
	</div>


@endsection()


@section('page_js')
	
	<script type="text/javascript" src='{{ asset("js/Poems/view.js") }}'></script>
	<script type="text/javascript" src='{{ asset("js/Poems/reply.js") }}'></script>
	<script type="text/javascript" src='{{ asset("js/Poems/follow.js") }}'></script>

	<!-- EXTERNAL JS FOR THE MODAL -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
@endsection()