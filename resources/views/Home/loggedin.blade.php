@extends('layouts.app')


@section('page_title')
	Ewi
@endsection()

@section('page_css')
	
	<link rel="stylesheet" type="text/css" href="{{ asset('css\Home\loggedin.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css\Home\feed.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 

	<meta name='csrf-token' content="{{ csrf_token() }}">

@endsection

@section('page_body')

	@if(Auth::user()->followings->count() < 3)

		
		<div class='container'>
			
			<p class='message'>Get your timeline started by following lovers of poetry like yourself</p>

			<div class='follow_container'>
				
				@foreach($follows as $follow)
				
					<div class='user'>

						<div style='background:url({{ $follow->avatar }}); background-size:cover; background-repeat: no-repeat' class='picture'>
							
						</div>

						<div class='details'>
							
							<p>{{ $follow->name }}</p>
							<span hidden>{{ $follow->id }}</span>
							<button><i class='fa fa-user-plus'></i> Follow</button>
						</div>
						
					</div>
					
				@endforeach
			</div>
		</div>
	@else

		<div class='page_container'>
			
			<div class='types'>

				<p class='active'><a href="">Feed</a></p>
				
				@foreach(Auth::user()->types as $type)

					<p>
						<a href="{{ route('type', ['type'=> strtolower($type->type) ] ) }}">{{ $type->type }}</a>
					</p>
				@endforeach
			</div>

			<div class='poems'>
				
				<span class='more' hidden>
					{{ $poem_count }}
				</span>
				@foreach($poems as $poem)

					<div class='poem'>										

						<div class='main_content'>
							
							<div class='picture'>
								<img src="{{ $poem->picture }}">
							</div>

							<div class='content'>
								<span>{{ $poem->title }}</span>
								<span>
									<div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div> <p>
										<a href="{{ route('profile', ['name'=>$poem->user->getNameSlug() ]) }}">{{ $poem->user->name }}</a>
									</p>
								</span>
								<span class='type'>
									<a href="{{ route('type', ['type'=>strtolower($poem->type->type)]) }}">{{ $poem->type->type }}</a>
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

			<div class='sidebar'>
				
				<div class='explore'>
					<div class='message'>Popular Tags This Week</div>

					<ul>
						@foreach($tags as $tag)

							<li>
								<a href="{{ route('tag.show', ['tag'=>strtolower($tag->tag)]) }}">{{ $tag->tag }}</a>
							</li>
						@endforeach()
					</ul>
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
								<button><i class='fa fa-user-plus'></i> Follow</button>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>

	@endif()


@endsection


@section('page_js')
	
	   <script type="text/javascript" src='{{ asset("js/jquery-3.2.1.min.js") }}'></script>
	   <script type="text/javascript" src=' {{ asset("js/Home/loggedin.js") }} '></script>
	   <script type="text/javascript" src=' {{ asset("js/Home/follow.js") }} '></script>
	   <script type="text/javascript" src=' {{ asset("js/Poems/fetchmorepoems.js") }} '></script>
@endsection


