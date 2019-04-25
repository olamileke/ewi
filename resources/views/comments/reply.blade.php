<div class='reply'>
	<div>
		<img src="{{ asset($reply->user->avatar) }}">

		<p class='detail'>

			@if($reply->user->id == Auth::id())

				You
			@else

				{{ $reply->user->name }}
			@endif
			 replied {{ $reply->created_at->diffForHumans() }}
		</p>
	</div>

	<p class='reply'>
		{{ $reply->reply }}
	</p>
</div>