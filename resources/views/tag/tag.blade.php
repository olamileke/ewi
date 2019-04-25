@foreach($tags as $tag)

	<div class='tag element'>
		<p class='tagname'>{{ $tag->tag }}</p>
		<p class='date'>you followed {{ $tag->created_at}}</p>
		<p class='no_of_poems'><a href="{{ route('tag.show', ['tag'=>strtolower($tag->tag) ]) }}">{{ $tag->number_of_posts }} Poems</a></p>

		<span class='tag-id' hidden>{{ $tag->id }}</span>

		<button class='unfollow-tag'><i class='fa fa-user-check'></i> Unfollow</button>
	</div>
@endforeach()	
