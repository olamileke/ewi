@extends('layouts.app')

@section('page_title')
	Search Results for {{ $searchterm }}
@endsection()


@section('page_css')
	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/search/index.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet"> 
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

	
	<meta name='csrf-token' content="{{ csrf_token() }}">

@endsection()


@section('page_body')
	
	
	<div class='container'>

		<div class='tabs'>
			<button class='active'>Poems</button>
			<button>People</button>
			<button>Tags</button>
		</div>
		
		<div class='poems'>

			@if($poems->count() > 0)
					
				@foreach($poems as $poem)

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

				@endforeach

			@else

				<div class='errormsg'>
					<i class='em em-anguished'></i>
					<span>No Poems exist for "{{ $searchterm }}"</span>
				</div>

			@endif()

		</div>

		<div class='people' hidden>
			
			@if($people->count() > 0)

				@foreach($people as $person)

					<div class='person'>
						
						<img src="{{ $person->avatar }}" width="60px" height="60px">

						<div>
							<p class='name'><a href="{{ route('profile', ['name'=>$person->getNameSlug()]) }}">{{ $person->name }}</a></p>
							<p class='about'>{{ str_limit($person->about_me,88) }}</p>
							<p class='info'>
								<span>{{ $person->followers->count() }}</span> {{ $person->getFollowerGrammar() }}
							</p>
						</div>

						<span class='id' hidden>{{ $person->id }}</span>

						@if( Auth::user()->checkFollowing($person->id) )

							<li>Following</li>
						@else

							<button class='follow'> <i class='fa fa-user-plus'></i> Follow</button>
						@endif()
					</div>

				@endforeach()

			@else
				<div class='errormsg'>
					<i class='em em-anguished'></i>
					<span>No People exist for "{{ $searchterm }}"</span>
				</div>
			@endif
		</div>

		<div class='tags' hidden>
			
			@if($tags->count() > 0)

				@foreach($tags as $tag)

					<div class='tag'>
						<p class='tagname'>{{ $tag->tag }}</p>
						<p class='date'>First Created {{ $tag->created_at->toFormattedDateString() }}</p>
						<p class='no_of_poems'><a href="{{ route('tag.show', ['tag'=>strtolower($tag->tag) ]) }}">{{ $tag->poems->count() }} Poems</a></p>
					</div>
				@endforeach()	

			@else

				<div class='errormsg'>
					<i class='em em-anguished'></i>
					<span>No Tags exist for "{{ $searchterm }}"</span>
				</div>
			@endif()	
		</div>

	</div>

	<div class='sidebar'>
				
		<div class='explore'>
			<div class='message'>What is being Searched</div>

			<ul>
				@foreach($searchterms as $term)

					<li>
						<a href="/search?q={{ $term->searchterm }}">{{ $term->searchterm }}</a>
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
							<a href="{{ route('profile', ['slug'=>$user->getNameSlug()]) }}">{{ $user->name }}</a>
						</p>								
						<span hidden>{{ $user->id }}</span>
						<button><i class='fa fa-user-plus'></i> Follow</button>
					</div>
				</li>
			@endforeach
		</ul>
	</div>

@endsection()


@section('page_js')

	<script type="text/javascript" src="{{ asset('js/search/index.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/Home/follow.js') }}"></script>

@endsection()
