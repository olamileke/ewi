@extends('layouts.app')

@section('page_title')
	Explore
@endsection()

@section('page_css')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/search/index.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/explore/index.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/info.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	

	<meta name='csrf-token' content="{{ csrf_token() }}">
@endsection()


@section('page_body')

	<div class='container'>
		<div class='tabs'>
			<button class='active'>Latest</button>
			<button>By rating</button>
			<button>By Engagement</button>
		</div>

		<div class='poems'>
			
			@foreach($latestpoems as $poem)
				<div class='poem'>								
					<!-- <p class='time'>{{ $poem->created_at->diffForHumans() }}</p>						 -->

					<div class='main_content'>
						
						<div class='picture' style='background:url({{$poem->picture}}); background-size:cover; background-position:15% 0'>
							
						</div>

						<div class='content'>
							<span>{{ $poem->title }}</span>
							<span>
								<div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div> <p>
									<a href="{{ route('profile', ['name'=>$poem->user->getNameSlug() ]) }}">
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

								@for($i=1; $i <= $poem->getRoundedRating(); $i++)

									<i class='fas fa-star'></i>

								@endfor()

								@for($i=1; $i <= 5 - $poem->getRoundedRating(); $i++)

									<i class='far fa-star'></i>
									
								@endfor()
							</div>

							<span class='ratingval'>{{ $poem->getRating(true) }} avg. rating </span>

							<a href="{{ route('poem.show', ['slug'=>$poem->slug]) }}" class='read'>Read</a>
						</div>
					</div>
				</div>
			@endforeach()
		</div>
		
	</div>

	<div class='sidebar'>
				
		<div class='explore'>
			<div class='message'>Poets to follow</div>
		</div>

		<ul class='follows'>
			@foreach($follows as $user)

				<li>
					<div style='background:url({{ $user->avatar }}); background-size:cover'></div>
					<div>
						<p>
							<a href="{{ route('profile', ['slug'=>$user->getNameSlug()]) }}">{{ $user->name }}</a>
						</p>								
						<span hidden>{{ $user->id }}</span>
						<button><i class='fa fa-user-plus'></i> Follow</button>
					</div>
				</li>
			@endforeach
		</ul>
	</div>

	
	<div class='InfoContainer' hidden>
		<div class="lds-ring explore">
			<div class='explore'></div>
			<div class='explore'></div>
			<div class='explore'></div>
			<div class='explore'></div>
		</div>
	</div>
@endsection()


@section('page_js')
	
	<script type="text/javascript" src="{{ asset('js/Explore/index.js') }}"></script>
	<script type="text/javascript" src=' {{ asset("js/Home/follow.js") }} '></script>
@endsection