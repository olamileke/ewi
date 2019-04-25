@foreach($actions as $action)	

	<div class='action'> 

		<div class='picture'>
			<img src="{{ asset($action->user->avatar) }}">
		</div>

		@if($action->action == 'review')

			<p><a href=#>{{ $action->user->name }}</a> reviewed <a href="#">{{ $action->poem->title }}</a>

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

			<p><a href=#>{{ $action->user->name }}</a> followed <a href="#">{{ $action->follow->name }}</a>

				<span class='time'>{{ $action->created_at->diffForHumans() }}
				</span>
			</p>

			<div class='action_picture'>
				<img src="{{ $action->follow->avatar }}">
			</div>
		@endif()

		 

		@if($action->action == 'read')

			<p> <a href=#>{{ $action->user->name }}</a> read <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

				<span class='time'>
					{{ $action->created_at->diffForHumans() }}
				</span>
			</p>

			<div class='action_picture'>
				<img src="{{ $action->poem->picture }}">
			</div>
		@endif()

		@if($action->action == 'comment')

			<p> <a href=#>{{ $action->user->name }}</a> commented on <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

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

				<p> <a href=#>{{ $action->user->name }}</a> wrote <a href="{{ route('poem.show', ['slug'=>$action->poem->slug]) }}">{{ $action->poem->title }}</a> 

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

			<p> <a href=#>{{ $action->user->name }}</a> liked <a href=#>{{ $action->comment->user->name }}'s</a>

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