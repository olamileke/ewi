@extends('layouts.app')

@section('page_title')
	
	Your Tags

@endsection()

@section('page_css')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/search/index.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/explore/index.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/info.css') }}">	
	<link rel="stylesheet" type="text/css" href="{{ asset('css\notifications\unfollow.css') }}">	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/tag/view.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet"> 
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">	

	<meta name='csrf-token' content="{{ csrf_token() }}">	
	
@endsection()

@section('page_body')

	<div class='tabs'>
		
		<button class='active'>Latest</button>

		<button>Alphabetically</button>
		<button>By Poem Numbers</button>	
	</div>
	<div class='container'>
		
		<div class='tags'>
			
			@if($tags->count() > 0)

				@foreach($tags as $tag)

					<div class='tag element'>
						<p class='tagname'>{{ $tag->tag }}</p>
						<p class='date'>you followed {{ $tag->created_at}}</p>
						<p class='no_of_poems'><a href="{{ route('tag.show', ['tag'=>strtolower($tag->tag) ]) }}">{{ $tag->number_of_posts }} Poems</a></p>

						<span class='tag-id' hidden>{{ $tag->id }}</span>

						<button class='unfollow-tag'><i class='fa fa-user-check'></i> Unfollow</button>
					</div>
				@endforeach()	

			@else

				<div class='errormsg'>
					<i class='em em-anguished'></i>
					<span>You have not followed any tag</span>
				</div>
			@endif()	
		</div>
			
	</div>


	<div class='sidebar'>
			
		<div class='explore'>
			<div class='message'>Tags to follow</div>

			<ul>
				@foreach($followtags as $tag)

					<li>
						<a href="{{ route('tag.show', ['tag'=>strtolower($tag->tag)]) }}">{{ $tag->tag }}</a>
					</li>
				@endforeach()
			</ul>
		</div>

	</div>

	<div class='InfoContainer' hidden>
		<div class="lds-ring explore">
			<div class='explore'></div>
			<div class='explore'></div>
			<div class='explore'></div>
			<div class='explore'></div>
		</div>
	</div>

	<div class='unfollowcontainer' hidden>
		
		<div class='dialog tag'>
			
		</div>
	</div>

@endsection()


@section('page_js')
	
	<script type="text/javascript" src="{{ asset('js/Tag/view.js') }}"></script>
@endsection()