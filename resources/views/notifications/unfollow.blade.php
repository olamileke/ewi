
<div class='img'>
	<img src="{{ asset($user->avatar) }}">
</div>

<p>Are you sure you want to unfollow {{ $user->name }}?</p>

<div class='buttons'>
	<button class='unfollow'>Unfollow</button>
	<button class='close'>Close</button>
</div>