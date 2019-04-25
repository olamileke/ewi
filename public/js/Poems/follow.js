"use strict"

$(document).ready(function() {

	let $authorid=$('span.author-id').text();

	// FOLLOWING THE POEM AUTHOR

	let $followbtn=$('button.follow');

	$followbtn.click(function() {

		followFunction($(this));
	})

	function followFunction($elem)
	{
		return $.ajax('/user/follow', {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'id':$authorid
			},
			success:function(data) {

				$elem.replaceWith('<li class="unfollow-dialog">Following</li>');

				$unfollow_options=$('.unfollow-dialog');

				$unfollow_options.click(function() {
		
					$unfollowcontainer.show();

					$body.addClass('noscroll');
				})
			}
		})
	}


	// UNFOLLOWING THE POEM AUTHOR

	let $unfollow_options=$('.unfollow-dialog');

	let $body=$('body');

	let $close_dialog=$('button.close');

	let $unfollowbtn=$('button.unfollow');

	let $unfollowcontainer=$('.unfollowcontainer');

	// TRIGGERING THE UNFOLLOW DIALOG

	$unfollow_options.click(function() {
		
		$unfollowcontainer.show();

		$body.addClass('noscroll');
	})


	// CLOSING THE UNFOLLOW DIALOG

	$close_dialog.click(function() {
		
		closeDialog();
	})


	function closeDialog()
	{
		$unfollowcontainer.hide();

		$body.removeClass('noscroll');
	}


	// UNFOLLOWING THE POEM AUTHOR

	$unfollowbtn.click(function() {

		unFollowAuthor($(this));
	})


	// THE UNFOLLOW EVENT/ACTION

	function unFollowAuthor($elem)
	{
		return $.ajax('/user/unfollow', {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'id':$authorid
			},
			error:function(data) {
				console.log(data.responseText)
			},
			success:function(data) {

				$unfollow_options.replaceWith('<button class="follow">Follow</button>');

				$followbtn=$('button.follow');

				$followbtn.click(function() {

					followFunction($(this));
				})

				closeDialog();
			}
		})
	}
})