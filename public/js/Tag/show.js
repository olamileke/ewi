"use strict"

$(document).ready(function() {

	let $followbtn=$('div.info button');

	let $followers_p_tag=$('p.followers');

	// FOLLOWING A TAG

	$followbtn.click(function() {

		followAction($(this));	
	})


	function followAction($this)
	{
		let $id=$this.parent().find('.tag-id').text();

		$.ajax(`/tag/follow/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')},
			success:function(data) {

				$this.replaceWith('<li>Following</li>');
				$followers_p_tag.text(`${data} followers`);

				$triggerunfollow=$('div.info li');

				$triggerunfollow.click(function() {

					$id=$(this).parent().find('.tag-id').text();
					$unfollowcontainer.show();
					$body.addClass('noscroll');
				})
			}
		})
	}


	// OPENING THE UNFOLLOW DIALOG

	let $triggerunfollow=$('div.info li');

	let $unfollowcontainer=$('.unfollowcontainer');

	let $body=$('body');

	let $id;

	$triggerunfollow.click(function() {

		$id=$(this).parent().find('.tag-id').text();
		$unfollowcontainer.show();
		$body.addClass('noscroll');
	})

	// UNFOLLOWING A TAG

	let $unfollowbtn=$('button.unfollow');

	$unfollowbtn.click(function() {

		unFollowAction();
		$unfollowcontainer.hide();
		$body.removeClass('noscroll');
		$triggerunfollow.replaceWith('<button>Follow</button>');

		$followbtn=$('div.info button');

		$followbtn.click(function() {

			followAction($(this));
		})
	})


	// CLOSING THE UNFOLLOW DIALOG

	let $closebtn=$('button.close');

	$closebtn.click(function() {
		$unfollowcontainer.hide();
		$body.removeClass('noscroll');
	})


	function unFollowAction()
	{
		$.ajax(`/tag/unfollow/${$id}`, {
			type:'POST',	
			headers:{'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')},
			success:function(data) {
			
				$followers_p_tag.text(`${data} followers`);				
			}					
		})
	}
})