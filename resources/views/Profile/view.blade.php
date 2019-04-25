@extends('Layouts.app')

@section('page_title')
	
	{{ $user->name }}	
@endsection()


@section('page_css')
	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/Profile/view.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/info.css') }}">	
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 	
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 

	<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection()


@section('page_body')
	
	<div class='container'>
		
		<div class='background-div'>

			@if($user->id == Auth::id())

				<button class='change-overlay'> CHANGE OVERLAY</button>

				<input type="file" class='overlay-change' hidden>

			@endif()

			<img class='back-img' src="{{ asset($user->overlayimage->image) }}">

			<div class="profile-pic">
				<img src="{{ asset($user->avatar) }}">

				<p class='name'>
					<!-- {{ $user->name }} -->				
				</p>
			</div>
		</div>

		<div class='detail'>

			<ul class='tabs'>
				<li class="active about">
					About {{ $identifier }}
				</li>
				<li class='poems'>

					@if($identifier == 'You')
						{{ $identifier }}r Poems

					@else

						{{ $identifier }}'s Poems

					@endif

				</li>
				<li class='following'>
					 Following <span> {{ $user->followings()->count() }}</span>
				</li>
				<li class='followers'>
					Followers <span> {{ $user->followers()->count() }}</span>
				</li>
			</ul>

			<div class='main-detail'>
				<div class='about'>
					{{ $user->about_me }}
				</div>

				<div class='poems' hidden>
					@foreach($user->poems as $poem)

						<div class='poem'>								
							<!-- <p class='time'>{{ $poem->created_at->diffForHumans() }}</p>						 -->

							<div class='main_content'>
								
								<div class='picture' style='background:url({{$poem->picture}}); background-size:cover; background-position:15% 0'>
									
								</div>

								<div class='content'>
									<span>{{ $poem->title }}</span>
									<span><div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div> <p>{{ $poem->user->name }}</p></span>
									<span class='type'>{{ $poem->type->type }}</span>
									<div class='ratings'>

										@for($i=1; $i <= $poem->getRoundedRating(); $i++)

											<i class='fas fa-star'></i>

										@endfor()

										@for($i=1; $i <= 5 - $poem->getRoundedRating(); $i++)

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

				<div class='following' hidden>
					@foreach($user->followings as $u)
					
						<div class='user'>
							<img src="{{ asset($u->avatar) }}" width='40px' height='40px'>
							<p>
								<span><a href="{{ route('profile',['name'=>$u->getNameSlug() ]) }}">{{ $u->name }}</a></span>
								{{ str_limit($u->about_me,80) }}
							</p>
							@if( $user->checkFollowing($u->id) )

								<li>Following</li>
							@else

								<button class='follow'> <i class='fa fa-user-plus'></i> Follow</button>
							@endif()
						</div>
					@endforeach()
				</div>

				<div class='followers' hidden>
					@foreach($user->followers as $u)
					
						<div class='user'>
							<img src="{{ asset($u->avatar) }}" width='40px' height='40px'>
							<p>
								<span><a href="{{ route('profile',['name'=>$u->getNameSlug() ]) }}">{{ $u->name }}</a></span>
								{{ str_limit($u->about_me,80) }}
							</p>
							@if( $user->checkFollowing($u->id) )

								<li>Following</li>
							@else

								<button class='follow'> <i class='fa fa-user-plus'></i> Follow</button>
							@endif()
						</div>
					@endforeach()
				</div>
			</div>


			<div class='actions'>
				
				@foreach($actions as $action)

					<div class='action'> 						

						@if($action->action == 'review')

							<p>
								<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">{{ $identifier }}</a> reviewed <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}"> {{ $action->poem->title }} </a>

								<span class='action_id' hidden>{{ $action->id }}</span>

								<span>
									{{ $action->created_at->diffForHumans() }}
									<button class='view'>read</button>
								</span>
							</p>
							<img src="{{ $action->poem->picture }}" width='35px' height='35px'>
							
						@endif()


						@if($action->action == 'follow')

							<p>
								<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">{{ $identifier }}</a> followed 
								<a href="{{ route('profile', ['name'=>$action->follow->getNameSlug()]) }}">{{ $action->follow->name }}</a>
								<span>{{ $action->created_at->diffForHumans() }}</span>
							</p>

							<img src="{{ $action->follow->avatar }}" width='35px' height='35px'>
							
						@endif()

						 

						@if($action->action == 'read')

							<p>
								<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">{{ $identifier }}</a> read <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}"> {{ $action->poem->title }} </a>
								<span>
									{{ $action->created_at->diffForHumans() }}
								</span>
							</p>
							<img src="{{ $action->poem->picture }}" width='35px' height='35px'>
							
											
						@endif()

						@if($action->action == 'comment')
							<p>
								<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">{{ $identifier }}</a> read <a href="{{ route('poem.show', ['slug'=>$action->comment->user->slug]) }}"> {{ $action->comment->user->name }}'s </a>
								comment

								<span class='action_id' hidden>{{ $action->id }}</span>

								<span>
									{{ $action->created_at->diffForHumans() }}
									<button class='view'>read</button>									
								</span>
							</p>
							<img src="{{ $action->comment->user->avatar }}" width="35px" height="35px">
							
						@endif()

						@if($action->action == 'write')
							<p>
								<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">{{ $identifier }}</a> wrote <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}"> {{ $action->poem->title }} </a>
								<span>{{ $action->created_at->diffForHumans() }}</span>
							</p>
							<img src="{{ $action->poem->picture }}" width='35px' height='35px'>
							
						@endif()


						@if($action->action == 'Like')
							<p>
								<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">{{ $identifier }}</a> liked <a href="{{ route('profile', ['slug'=>$action->comment->user->getNameSlug()]) }}"> {{ $action->comment->user->name }}'s </a>
								comment

								<span class='action_id' hidden>{{ $action->id }}</span>

								<span>
									{{ $action->created_at->diffForHumans() }}
									<button class='view'>read</button>									
								</span>
							</p>
							<img src="{{ $action->comment->user->avatar }}" width="35px" height="35px">
							
						@endif()

					</div>	
				@endforeach()
			</div>
		</div>
	</div>

	<div class='InfoContainer' hidden>

		<div class='info'>			
			<div class='closebtn'>
				<span></span>
			</div>
	
		</div>
	</div>


@endsection()


@section('page_js')
	
	<script type="text/javascript" src="{{ asset('js/Profile/view.js') }}"></script>
	<script type="text/javascript" src='{{ asset("js/notifications/fetchmorenotifs.js") }}'></script>
	
@endsection()