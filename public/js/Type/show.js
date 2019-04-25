"use strict"

$(document).ready(function() {

	var $route=document.URL;

	var $type=$route.split('type/')[1];
	
	// alert($('span:first').css('width'));

	var $nav_tabs=$('.types p');

	$nav_tabs.each(function() {

		var $this=$(this);

		if($this.text().trim().toLowerCase() == $type)
		{
			$this.addClass('active');
		}
	})
})