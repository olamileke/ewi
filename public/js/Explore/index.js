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

	let $tabs=$tabsmenu.find('button');

	let $infocontainer=$('div.InfoContainer');

	let $poemscontainer=$('div.poems');

	let $body=$('body');

	$tabs.click(function() {
		let $this=$(this);

		if(!$this.hasClass('active'))
		{		
			$tabs.each(function() {
				$(this).removeClass('active');
			})

			$this.addClass('active');

			makePoemRequest($this.text());
		}
	})


	function makePoemRequest($text)
	{
		$infocontainer.show();
		$body.addClass('noscroll');

		if($text.trim().includes('Latest'))
		{
			getPoems('getlatest');
		}

		if($text.trim().includes('rating'))
		{
			getPoems('getrated');
		}

		if($text.trim().includes('Engage'))
		{
			getPoems('getbyengagement')
		}
	}


	// GETTING THE LATEST POEMS

	function getPoems($type)
	{
		return $.ajax(`/explore/${$type}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$poemscontainer.html(data);
				$infocontainer.hide();
				$body.removeClass('noscroll');
			}
		})
	}
})