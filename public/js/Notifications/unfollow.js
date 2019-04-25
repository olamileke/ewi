"use strict"

$(document).ready(function() {

	let $unfollowbtn=$('div.action li');

	let $unfollowcontainer=$('.unfollowcontainer');

	let $dialog=$unfollowcontainer.find('.dialog');

	let $body=$('body');

	$unfollowbtn.click(function() {
		
		let $this=$(this);

		let $id=$this.parent().find('.action-user-id').text();

		$dialog.html(`<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`);

		unFollowOptions($id);
	})


	// MAKING THE AJAX CALL TO PROMPT THE USER IF HE/SHE WANTS TO UNFOLLOW

	function unFollowOptions($id)
	{
		$body.addClass('noscroll');
		$unfollowcontainer.show();

		$.ajax(`/user/getunfollowinfo/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')},
			success:function(data) {
				$dialog.html(data);

				// CLOSING THE UNFOLLOW DIALOG

				$dialog.find('button.close').click(function() {
					$unfollowcontainer.hide();
					$body.removeClass('noscroll');
				})
			}
		})
	}
})