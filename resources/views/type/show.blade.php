@extends('layouts.app')


@section('page_title')
	
	{{ $typez->type }}

@endsection()

@section('page_css')
	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/Home/feed.css') }}">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	

	<meta name='csrf-token' content="{{ csrf_token()}}">

@endsection()

@section('page_body')

		<div class='page_container'>
			
			<div class='types'>

				<p><a href="/">Feed</a></p>
				
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

				@if($typez->poems->count() > 0)				
					
					@foreach($poems as $poem)

						<div class='poem'>								
							<!-- <p class='time'>{{ $poem->created_at->diffForHumans() }}</p>						 -->

							<div class='main_content'>
								
								<div class='picture' style='background:url({{$poem->picture}}); background-size:cover; background-position:15% 0'>
									
								</div>

								<div class='content'>
									<span>{{ $poem->title }}</span>
									<span>
										<div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div>
										 <p>
										 	<a href="{{ route('profile', ['name'=>$poem->user->getNameSlug()]) }}">{{ $poem->user->name }}</a>
										 </p>
									</span>
									<span class='type'>
										<a href="{{ route('type', ['type'=>$poem->type->type]) }}">{{ $poem->type->type }}</a>
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
					leke
				@endif
			</div>


			<div class='sidebar'>				

				<div class='explore'>
					<div class='message'>Explore Other Types</div>

					<ul>
						@foreach($other_types as $type)

							<li>
								<a href="{{ route('type', ['type'=> strtolower($type->type) ] ) }}">{{ $type->type }}</a>
							</li>
						@endforeach()
					</ul>
				</div>
			</div>
		</div>

@endsection

@section('page_js')
	
	<script type="text/javascript" src="{{ asset('js/type/show.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/Poems/fetchmorepoems.js') }}"></script>
@endsection