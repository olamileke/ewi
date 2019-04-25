
@if($action->action == 'review')

	<div class='closebtn'>
		<span></span>
	</div>	

	<div class='topInfo'>
		<img src="{{ $action->user->avatar }}" width="40px" height="40px">

		<p>
			{{ $action->user->name }} on {{ $action->poem->title }}

			<span>

				@for($i= 1; $i<= $action->comment->rating->rating; $i++)

					<i class='fas fa-star rate'></i>
				@endfor

				@for($i=1; $i<= 5 - $action->comment->rating->rating; $i++)

					<i class='far fa-star rate'></i>
				@endfor()
							
			</span>
		</p>
	</div>
	<div class='review'>
		{{ $action->comment->comment}}


		<p><i class='far fa-clock'></i>  {{ $action->created_at->diffForHumans() }}</p>
	</div>

@elseif($action->action == 'comment')

	<div class='closebtn'>
		<span></span>
	</div>	

	<div class='closebtn'>
		<span></span>
	</div>	
	
	<div class='topInfo'>
		<img src="{{ $action->user->avatar }}" width="40px" height="40px">

		<p>
			{{ $action->user->name }} on {{ $action->poem->title }}
		</p>
	</div>
	<div class='review'>
		{{ $action->comment->comment}}

		<p><i class='far fa-clock'></i>  {{ $action->created_at->diffForHumans() }}</p>
	</div>

@elseif($action->action == 'Like')

	<div class='closebtn'>
		<span></span>
	</div>	

	<div class='topInfo'>
		<img src="{{ $action->comment->user->avatar }}" width="40px" height="40px">

		<p>
			{{ $action->comment->user->name }} on {{ $action->comment->poem->title }}

			@if($action->comment->rating)
				<span>

					@for($i= 1; $i<= $action->comment->rating->rating; $i++)

						<i class='fas fa-star rate'></i>
					@endfor

					@for($i=1; $i<= 5 - $action->comment->rating->rating; $i++)

						<i class='far fa-star rate'></i>
					@endfor()
								
				</span>
			@endif
		</p>
	</div>
	<div class='review'>
		{{ $action->comment->comment}}


		<p>
			<i class='fa fa-heart'></i> by {{ $action->user->name }}

			@if($action->comment->likes->count() - 1 > 0)
				 and

			 {{ $action->comment->likes->count() - 1 }} other

			@endif()
		</p>
	</div>

@endif()