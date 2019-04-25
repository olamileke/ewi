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



	// TOGGLING THE TAB SIDEMENU

	let $tabs=$tabsmenu.find('button');

	$tabs.click(function() {

		let $this=$(this);
		
		$tabs.each(function() {
			$(this).removeClass('active');
		})

		$this.addClass('active');

		setVisible($this.text().trim().toLowerCase());
	})

	let $textarray=['poems', 'people', 'tags'];


	// FUNCTION TO DISPLAY THE POEMCONTAINER, PEOPLECONTAINER OR TAGCONTAINER

	function setVisible($text)
	{
		for(let $i=0; $i < $textarray.length; $i++)
		{
			if($text == $textarray[$i])
			{
				$(`div.${$text}`).show();
			}
			else
			{
				$(`div.${$textarray[$i]}`).hide();
			}

		}
	}
})