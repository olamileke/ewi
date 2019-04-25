<div class='closebtn'>
	<span></span>
</div>

<div class='topInfo'>
	<img src="{{ $comment->user->avatar }}" width="40px" height="40px">

	<p>
		{{ $comment->user->name }} on {{ $comment->poem->title }}

		<span>

			@for($i= 1; $i<= $comment->rating->rating; $i++)

				<i class='fas fa-star rate'></i>
			@endfor

			@for($i=1; $i<= 5 - $comment->rating->rating; $i++)

				<i class='far fa-star rate'></i>
			@endfor()
						
		</span>
	</p>
</div>
<div class='review'>
	{{ $comment->comment}}

</div>

<textarea autofocus>
</textarea>

<button class='logreply'>Reply</button>