@extends('layouts.app')

@section('page_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css\Tag\show.css') }}">	
	<link rel="stylesheet" type="text/css" href="{{ asset('css\notifications\unfollow.css') }}">	
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 		
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 


	<meta name='csrf-token' content='{{ csrf_token() }}'>
@endsection()

@section('page_title')
	
	Tag - {{ $tag->tag }}
@endsection()


@section('page_body')	
	
	<div class='container'>			
			
		<span class='tagcount' hidden>{{ $tag->poems->count() }}</span>

		<div class='info'>
			<p class='tag'>{{ $tag->tag }}</p>
			<p class='date'>First created {{ $tag->created_at->toFormattedDateString() }}</p>
			<div>
				<p class='poems'>{{ $tag->poems->count() }} {{ $tag->getPoemText() }}</p>			
				<p class='followers'>{{ $tag->users->count() }} {{ $tag->getFollowersText() }}</p>
				<span class='tag-id' hidden>{{ $tag->id }}</span>

				@if(Auth::user()->followedTag($tag->id))

					<li>Following</li>
				@else
					<button>Follow</button>
				@endif
			</div>
		</div>

		<div class='poems'>
			
			@foreach($poems as $poem)

				<div class='poem'>					
					
					<!-- <p class='time'>{{ $poem->created_at->diffForHumans() }}</p>						 -->

					<div class='main_content'>
						
						<div class='picture'>
							<img src="{{ $poem->picture }}">
						</div>

						<div class='content'>
							<span>{{ $poem->title }}</span>
							<span>
								<div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div> 
								<p>
									<a href="{{ route('profile', ['name'=>$poem->user->getNameSlug()]) }}">
										{{ $poem->user->name }}
									</a>
								</p>
							</span>
							<span class='type'>
								<a href="{{ route('type', ['type'=>strtolower($poem->type->type)]) }}">
									{{ $poem->type->type }}
								</a>
							</span>
							<div class='ratings'>
								@for($i=1; $i <= $poem->getRating(); $i++)

									<i class='fas fa-star'></i>

								@endfor()

								@for($i=1; $i <= 5 - $poem->getRating(); $i++)

									<i class='far fa-star'></i>
									
								@endfor()
							</div>

							<span class='ratingval'>{{ $poem->getRating(true) }} avg. rating </span>
							<a href="{{ route('poem.show', ['slug'=>$poem->slug]) }}" class='read'>Read</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<div class='sidebar'>
			<div class='message'>
				@if($follows->count() > 0)

					Poets following {{ strtolower($tag->tag) }}
				@else
					Be the first to follow

				@endif
			</div>

			<ul class='follows'>
				@foreach($follows as $user)
					<li>
						<div style='background:url({{ $user->avatar }}); background-size:cover'></div>
						<div>
							<p>
								<a href="{{ route('profile', ['slug'=>$user->getNameSlug() ]) }}">{{ $user->name }}</a>
							</p>								
							<span hidden>{{ $user->id }}</span>

							@if(Auth::user()->checkFollowing($user->id))

								<button><i class="fas fa-user-check"></i> Unfollow</button>
							@else
								<button><i class='fa fa-user-plus'></i> Follow</button>
							@endif
						</div>
					</li>
				@endforeach()
			</ul>
		</div>

	</div>	


	<div class='unfollowcontainer' hidden>
		
		<div class='dialog tag'>
			<p class='title'> {{$tag->tag}} </p>

			<p class='tag'>Are you sure you want to unfollow {{ $tag->tag }} ?</p>

			<div class='buttons'>
				<button class='unfollow'>Unfollow</button>
				<button class='close'>Close</button>
			</div>
		</div>
	</div>
@endsection()


@section('page_js')
	
	<script type="text/javascript" src="{{ asset('js/Tag/show.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/You/fetchmorepoems2.js') }}"></script>
	<script type="text/javascript" src=' {{ asset("js/Home/follow.js") }} '></script>
@endsection()