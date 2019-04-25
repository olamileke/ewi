@extends('layouts.app')

@section('page_title')
	
	{{ Auth::user()->name }}'s Poems
@endsection()


@section('page_css')
	
	<link rel="stylesheet" type="text/css" href="{{ asset('css\Tag\show.css') }}">	
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
@endsection()


@section('page_body')

	
	<div class='container'>
		<div class='poems' style='margin-top:3vh'>
				
			@foreach($poems as $poem)

				<div class='poem'>					
					
					<!-- <p class='time'>{{ $poem->created_at->diffForHumans() }}</p>						 -->

					<div class='main_content'>
						
						<div class='picture'>
							<img src="{{ $poem->picture }}">
						</div>

						<div class='content'>
							<span>{{ $poem->title }}</span>
							<span><div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div> <p>{{ $poem->user->name }}</p></span>
							<span class='type'>{{ $poem->type->type }}</span>
							<div class='ratings'>
								@for($i=1; $i <= $poem->getRating(); $i++)

									<i class='fas fa-star'></i>

								@endfor()

								@for($i=1; $i <= 5 - $poem->getRating(); $i++)

									<i class='far fa-star'></i>
									
								@endfor()
							</div>

							<span class='ratingval'>{{ $poem->getRating(true) }} avg. rating </span>
							<a href="{{ route('poem.show', ['slug'=>$poem->slug]) }}">Read</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

@endsection()