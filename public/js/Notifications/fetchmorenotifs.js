"use strict"

$(document).ready(function() {


	// DISPLAYING A DIALOG CONTAINING DETAILED INFORMATION ABOUT A REVIEW, COMMENT OR LIKE

	let $body=$('body');

	let $infocontainer=$(".InfoContainer");

	let $infodiv=$infocontainer.find('.info');

	let $infobtn=$('.view');

	let $closebtn=$infocontainer.find('.closebtn');


	function displayDetails($this)
	{
		$body.addClass('noscroll');
		$infocontainer.show();

		let $parent=$this.parent().parent();

		let $id=$parent.find('.action_id').text();

		getDetail($id);
	}

	$infobtn.click(function() {

		displayDetails($(this));		
	})


	// GETTING THE DETAIL OF THE REVIEW, COMMENT OR LIKE

	function getDetail($id)
	{
		// CREATING THE CIRCULAR LOADER WHEN THE DIALOG FIRST OPENS

		$infodiv.html(`
						<div class='closebtn'>
							<span></span>
						</div>
						<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`);

		$.ajax(`/action/getdetail/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			error:function(data) {
				console.log(data.responseText);
			},
			success:function(data) {
				$infodiv.html(data)

				$infodiv.find('.closebtn').click(function() {
					$infocontainer.hide();
					$body.removeClass('noscroll');
				})
			}
		})
	}

	// CLOSING THE EXTRA INFORMATION DIALOG

	$closebtn.click(function() {
		$infocontainer.hide();
		$body.removeClass('noscroll');
	})


	// LOADING MORE NOTIFICATIONS WHEN THE USER IS AT THE END OF THE PAGE
	
	let $tabs=$('div.heading span');

	let $loader=$('.lds-css');

	let $followpage=1;

	let $your_actions_page=2;

	// DETERMINING IF THE USER IS AT THE END OF THE PAGE

	$(window).scroll(function() {
		let $doc_height=$(document).height();

		let $scrollHeight=$(window).height() + $(window).scrollTop();


		if(($doc_height - $scrollHeight) / $doc_height === 0)
		{
			$tabs.each(function() {
			let $this=$(this);

			if($this.hasClass('active'))
			{
				if($this.text().trim() == 'Following')
				{
					let $count=$('span.followings_actions_count').text().trim();

					loadFollowingsActions($count);
				}
				else if($this.text().trim() == 'You')
				{
					let $count=$('span.your_actions_count').text().trim();

					// loadYourActions($count);
				}
			}

		})
		}
	})


	// LOADING MORE ACTIONS BY PEOPLE YOU FOLLOW

	function loadFollowingsActions(num)
	{
		if(num > $('.follow_actions .action').length)
		{
			setTimeout(function() {

				$loader.show();
			}, 3000)

			setTimeout(function() {

				let $followactions=$('.follow_actions');

				
					$.ajax(`/notifs/followings/10/${$followpage}`, {
						type:'POST',
						headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
						success:function(data) {
							$followactions.append(data);
							$loader.hide();

							$followpage++;

							$infobtn=$('.view');

							$infobtn.click(function() {

								displayDetails($(this));		
							})
						}
					})
			}, 5500)
		}
	}


	// LOADING MORE OF YOUR ACTIONS

	function loadYourActions(num)
	{
		let $youractions=$('.your_actions');

		if(num > $('.your_actions .action').length)
		{
			setTimeout(function() {

				$loader.show();
			}, 3000)

			setTimeout(function() {

				$.ajax(`/notifs/you/10?page=${$your_actions_page}`, {
					type:'POST',
					headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
					error:function(data) {
						console.log(data.responseText);
					},
					success:function(data) {
						$youractions.append(data);

						$loader.hide();
						$your_actions_page++;

						$infobtn=$('.view');

						$infobtn.click(function() {

							displayDetails($(this));		
						})
					}
				})

				let $youractions=$('.your_actions');

			},5500)
		}
	}

})