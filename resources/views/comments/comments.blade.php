
@foreach($comments as $comment)

	<div class='comment'>

		<span class='time'>
			{{$comment->created_at->diffForHumans() }}
		</span>
		<div>
			<img src="{{ $comment->user->avatar }}" width='35px' height='35px'>
			<p>
				<span>
				@if($comment->rating)

					@if(Auth::id() == $comment->user->id)

						You

					@else

						{{ $comment->user->name }}

					@endif 

					 reviewed 
					</span>

					<span>
						@for($i= 1; $i<= $comment->rating->rating; $i++)

							<i class='fas fa-star rate'></i>
						@endfor

						@for($i=1; $i<= 5 - $comment->rating->rating; $i++)

							<i class='far fa-star rate'></i>
						@endfor()
					</span>

				@else

					<p>{{ $comment->user->name }} commented 

				@endif()
			</p>
		</div>
		<div>
			{{$comment->comment}}
		</div>
		<div>
			@if(Auth::user()->hasLiked($comment->id))

				<i class='fas fa-heart'></i>
			@else
				<i class='far fa-heart'></i>
			@endif()

			<i class='id' hidden>{{ $comment->id }}</i>
			<span>{{ $comment->likes->count()}}</span>
			<button>Reply</button>
		</div>
	</div>

@endforeach()