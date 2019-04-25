"use strict"

$(document).ready(function() {

	let $tabsmenu=$('div.tabs');

	// SETTING THE POSITION OF THE TABS  SIDEMENU WHEN THE USER SCROLLS


	$(window).scroll(function() {

		if($(window).scrollTop() > 63)
		{
			$tabsmenu.addClass('pos_fixed');
		}
		else
		{
			$tabsmenu.removeClass('pos_fixed');
		}
	})


	// TOGGLING BETWEEN THE DIFFERENT TABAS

	let $tabs=$tabsmenu.find('button');

	let $infocontainer=$('div.InfoContainer');

	let $tagscontainer=$('div.tags');

	let $body=$('body');

	$tabs.click(function() {
		let $this=$(this);

		if(!$this.hasClass('active'))
		{		
			$tabs.each(function() {
				$(this).removeClass('active');
			})

			$this.addClass('active');

			makeTagRequest($this.text());
		}
	})


	function makeTagRequest($text)
	{
		$infocontainer.show();
		$body.addClass('noscroll');

		if($text.includes('Alphabet'))
		{
			fetchTags('alphabet');
		}

		if($text.includes('Number'))
		{
			fetchTags('number');
		}

		if($text.includes('Latest'))
		{
			fetchTags('latest');
		}
	}

	// FUNCTION TO FETCH

	function fetchTags($text)
	{
		return $.ajax(`/tag/order/${$text}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$tagscontainer.html(data);

				$tagscontainer.find('button.unfollow-tag').click(function() {

					triggerUnfollowDialog($(this));
				})

				$infocontainer.hide();
				$body.removeClass('noscroll');
			}
		})
	}


	// TRIGGERING THE UNFOLLOW DIALOG

	let $triggerunfollow=$('button.unfollow-tag');

	let $unfollowcontainer=$('div.unfollowcontainer');

	let $unfollowdialog=$unfollowcontainer.find('.dialog');

	$triggerunfollow.click(function() {
		
		triggerUnfollowDialog($(this));
	})


	function triggerUnfollowDialog($elem)
	{
		let $id=$elem.parent().find('.tag-id').text();

		$unfollowcontainer.show();
		$body.addClass('noscroll');
		$unfollowdialog.html(`<div class="lds-ring">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>`);


		return $.ajax(`/tag/fetchinfo/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$unfollowdialog.html(data);

				$unfollowdialog.find('button.close').click(function() {
					closeDialog();
				})

				$unfollowdialog.find('button.unfollow').click(function() {
					unFollowTag($id, $elem.parent());
				})
			}
		})
	}

	// CLOSING THE UNFOLLOW DIALOG

	function closeDialog()
	{
		$unfollowcontainer.hide();
		$body.removeClass('noscroll');
	}


	// UNFOLLOWING A TAG

	function unFollowTag($id, $parent)
	{
		return $.ajax(`/tag/unfollow/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$unfollowcontainer.hide();
				$body.removeClass('noscroll');
				$parent.remove();
				toastr.success('Tag unfollowed');
			}
		})
	}

})