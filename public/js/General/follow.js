"use strict"

$(document).ready(function() {

	// FOLLOWING A USER

	let $followbtn=$('button.follow');

	let $unfollowbtn=$('div.action li');

	let $body=$('body');

	let $id;

	$followbtn.click(function() {

		let $this=$(this);

		followUser($this);
	})


	function followUser($this)
	{
		$id=$this.parent().find('span.id').text();

		$.ajax('/user/follow', {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'id':$id,
			},
			success:function(data) {
				$this.replaceWith('<li>Following</li>');

				$unfollowbtn=$('div.action li');

				$unfollowbtn.click(function() {

					let $this=$(this);

					unFollowOptions($this);
				})
			}
		})
	}	


	// UNFOLLOWING A USER

	let $unfollowcontainer=$('.unfollowcontainer');

	let $dialog=$unfollowcontainer.find('.dialog');

	$unfollowbtn.click(function() {
		
		let $this=$(this);

		unFollowOptions($this);
	})


	// MAKING THE AJAX CALL TO PROMPT THE USER IF HE/SHE WANTS TO UNFOLLOW

	function unFollowOptions($this)
	{
		$id=$this.parent().find('.action-user-id').text();

		$dialog.html(`<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`);

		$body.addClass('noscroll');
		$unfollowcontainer.show();

		$.ajax(`/user/getunfollowinfo/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')},
			success:function(data) {
				$dialog.html(data);

				// CREATING THE UNFOLLOW EVENT

				setTimeout(function() {
					$dialog.find('button.unfollow').click(function() {
						unFollowUser($this);
						$unfollowcontainer.hide();
						$body.removeClass('noscroll');					
					})
				}, 1000)

				// CLOSING THE UNFOLLOW DIALOG

				$dialog.find('button.close').click(function() {
					$unfollowcontainer.hide();
					$body.removeClass('noscroll');
				})
			}
		})
	}


	// ACTUALLY UNFOLLOWING THE USER

	function unFollowUser($elem)
	{
		return $.ajax('/user/unfollow', {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'id':$id
			},
			success:function(data) {
				$elem.replaceWith(`<button class='follow'>
								<i class='fa fa-user-plus'></i> Follow 
							</button>`);

				$followbtn=$('button.follow');

				$followbtn.click(function() {

					let $this=$(this);

					followUser($this);
				})
			}
		})
	}
})