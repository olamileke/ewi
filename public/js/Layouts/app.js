"use strict"

$(document).ready(function() {
	
	var $host=location.hostname;

	var $searchform=$('header form');

	var $body=$('body');

	$searchform.submit(function(e) {

		let $this=$(this);

		if(!$this.find('input').val())
		{
			$searchform.find('input').css('border','1px solid rgba(255,0,0,0.7)');
			e.preventDefault();
		}
	})

	// SETTING THE POSITION OF THE TYPES SIDEMENU WHEN THE USER SCROLLS

	let $types=$('div.types');


	$(window).scroll(function() {

		if($(window).scrollTop() > 63)
		{
			$types.addClass('pos_fixed');
		}
		else
		{
			$types.removeClass('pos_fixed');
		}
	})


	// SETTING THE ACTIVE INDICATOR

	var $links=$('header ul li');

	var $route=document.URL.split('8000')[1];

	var $routearray=['/','/poem/create','/trending','/explore'];

	var $links_text=['Feed', 'Create', 'Trending','Explore'];

	var $count=0;

	for(var $i=0; $i < $routearray.length; $i++)
	{
		if($route == $routearray[$i])
		{
			$links.each(function() {

				var $this=$(this);

				if($this.text().trim() == $links_text[$i])
				{
					$this.find('p').addClass('active');
				}
				else
				{
					$this.addClass('hover_active');
				}
			})
		}
		else
		{
			$count++;

			if($count == $routearray.length)
			{
				$links.addClass('hover');
			}
		}
	}

	// TOGGLING THE NAVBAR

	var $spanbtn=$('div.navtoggle');

	var $closebtn=$('header ul span.sidebar');

	var $navbar=$('header ul.sidebar');

	$spanbtn.click(function() {
		
		$navbar.addClass('active');	
		$body.addClass('noscroll');
	})

	$closebtn.click(function() {

		$navbar.removeClass('active');
		$body.removeClass('noscroll');

	})


	// DETERMINING THE NOTIFICATIONS TEXT

	var $notif=$('li.notif');

	if(screen.width < 868)
	{
		$notif.html('<a href="/notifications">Notifications</a>');
	}

	// TOGGLING THE VISIBILITY OF THE PROFILE ACTIONS ON A LARGE OR LAPTOP SCREEN

	var $toggleAction=$('div.profile.lg')

	var $actions=$toggleAction.find('ul');

	$toggleAction.click(function() {

		$actions.toggleClass('visible');
	})

	// TOGGLING THE VISIBILITY OF THE PROFILE ACTIONS ON A SMALLER SCREEN / TABLET/ IPAD

	var $toggleActionsSmall=$('div.profile.sm');

	var $actionsSmall=$('ul.actions');

	var $closebtn=$actionsSmall.find('span');

	$toggleActionsSmall.click(function() {
		$actionsSmall.addClass('visible');
		$body.addClass('noscroll');
	})

	$closebtn.click(function() {
		$actionsSmall.removeClass('visible');
		$body.removeClass('noscroll');
	})


})