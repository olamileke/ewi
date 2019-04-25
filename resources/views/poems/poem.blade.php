@foreach($poems as $poem)

	<div class='poem'>					
		
		<!-- @if($poem->engage_score >= 0)
			<div class='engage-score' style='position: absolute;top:84%; left:92%; padding:4px; border-radius:50%; border:1px solid rgba(0,0,0,0.4); font-family:"Quicksand", sans-serif'>
				{{ $poem->engage_score }}	
			</div>
		@endif
 -->
		<div class='main_content'>
			
			<div class='picture'>
				<img src="{{ $poem->picture }}">
			</div>

			<div class='content'>
				<span>{{ $poem->title }}</span>
				<span>
					<div style='background:url({{ $poem->user->avatar  }}); background-size:cover'></div>
					 <p>
					 	 <a href="{{ route('profile', ['name'=>$poem->user->getNameSlug() ]) }}">{{ $poem->user->name }}</a>
					 </p>
				</span>
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

				<a href="{{ route('poem.show', ['slug'=>$poem->slug]) }}" class='read'>Read</a>
			</div>
		</div>
	</div>

@endforeach()