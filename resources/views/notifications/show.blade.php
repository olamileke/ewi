@extends('Layouts.app')


@section('page_title')
	
	Notifications
@endsection

@section('page_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/show.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/info.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/unfollow.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Aleo" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">

	<meta name='csrf-token' content="{{ csrf_token() }}">	
@endsection()


@section('page_body')


	<div class='container'>
		
		<div class='heading'>
			<div>
				<span class='active'>
					Following				
				</span>				
			</div>

			<div>
				<span>
					You
				</span>
			</div>

			<p class='following'></p>
		</div>

		<div class='follow_actions active'>
			
			<span class='followings_actions_count' hidden>{{ $followingscount }}</span>
			@foreach($actions as $action)		


				<div class='action'> 

					<div class='picture'>
						<img src="{{ asset($action->user->avatar) }}">
					</div>

					@if($action->action == 'review')

						<p><a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> reviewed <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a>

							<span class='action_id' hidden>{{ $action->id }}</span>

							<span class='time'>
								{{ $action->created_at->diffForHumans() }} 
								<button class='view'>read</button>
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->poem->picture }}">
						</div>													
					@endif()

					@if($action->action == 'follow')

						<p><a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> followed <a href="#">{{ $action->follow->name }}</a>

							<span class='time'>{{ $action->created_at->diffForHumans() }}
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->follow->avatar }}">
						</div>
					@endif()

					 

					@if($action->action == 'read')

						<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> read <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->poem->picture }}">
						</div>
					@endif()

					@if($action->action == 'comment')

						<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> commented on <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

							<span class='action_id' hidden>{{ $action->id }}</span>
				
							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
								<button class='view'>read</button>
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->poem->picture }}">
						</div>
					@endif()

					@if($action->action == 'write')

						@if($action->poem)

							<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
								{{ $action->user->name }}</a> wrote <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
							</span>
							</p>

							<div class='action_picture'>
								<img src="{{ $action->poem->picture }}">
							</div>

						@endif	
					@endif()


					@if($action->action == 'Like')

						<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> liked <a href=#>{{ $action->comment->user->name }}'s</a>

							comment 


							<span class='action_id' hidden>{{ $action->id }}</span>

							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
								<button class='view'>read</button>
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->comment->user->avatar }}">
						</div>
					@endif()

				</div>	
						

			@endforeach()
		</div>

		<div class='your_actions'>

			<span class='your_actions_count' hidden>{{ $youractionscount }}</span>
			@foreach($your_actions->take(10) as $action)

				<div class='action'> 


					<div class='picture'>
						<img src="{{ asset($action->user->avatar) }}">
						
					</div>

					@if($action->action == 'follow')

						<p>
							<a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
								{{ $action->user->name }}</a> followed you

							<span class='time'>{{ $action->created_at->diffForHumans() }}</span>
						</p>

						<span class='action-user-id' hidden>{{$action->user->id}}</span>

						@if(Auth::user()->checkFollowing($action->user->id))

							<li>Following</li>
						@else
							<button class='follow'>
								<i class='fa fa-user-plus'></i> Follow 
							</button>
						@endif

					@endif()


					@if($action->action == 'Like')

						<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> liked your</a>

							comment <span class='action_id' hidden>{{ $action->id }}</span>

							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
								<button class='view'>read</button>
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->comment->user->avatar }}">
						</div>
					@endif()

					@if($action->action == 'comment')

						<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> commented on your poem
							<span class='action_id' hidden>{{ $action->id }}</span> 
							
							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
								<button class='view'>read</button>
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->poem->picture }}">
						</div>
					@endif()

					@if($action->action == 'review')

						<p><a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> reviewed your poem

							<span class='action_id' hidden>{{ $action->id }}</span>

							<span class='time'>
								{{ $action->created_at->diffForHumans() }}
								<button class='view'>read</button>
							</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->poem->picture }}">
						</div>													
					@endif()


					<span class='id' hidden>{{ $action->user->id }}</span>

					@if($action->action == 'read')

						<p> <a href="{{ route('profile', ['name'=>$action->user->getNameSlug()]) }}">
							{{ $action->user->name }}</a> read <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

							<span class='time'>{{ $action->created_at->diffForHumans() }}</span>
						</p>

						<div class='action_picture'>
							<img src="{{ $action->poem->picture }}">
						</div>
					@endif

				</div>		

			@endforeach()

		</div>

		<div class='InfoContainer' hidden>

			<div class='info'>
				
				<div class='closebtn'>
					<span></span>
				</div>			
				
			</div>
		</div>

		<div class='unfollowcontainer' hidden>
			
			<div class='dialog'>
				
			</div>
		</div>

	</div>	
	
@endsection


@section('page_js')

	<script type="text/javascript" src='{{ asset("js/notifications/show.js") }}'></script>	
	<script type="text/javascript" src='{{ asset("js/General/follow.js") }}'></script>	
	<script type="text/javascript" src='{{ asset("js/notifications/fetchmorenotifs.js") }}'></script>
	<script type="text/javascript" src='{{ asset("js/notifications/unfollow.js") }}'></script>
@endsection()