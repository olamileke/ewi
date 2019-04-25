"use strict"

$(document).ready(function() {
	var $span=$('div.heading span');

	var $activespan=$('span.active');

	var $p=$('.heading p');

	var $class='following';

	var $nextclass='you';

	var $inter=$class;

	var $follow_acts=$('.follow_actions');

	var $your_acts=$('.your_actions');

	// TOGGLING THE NOTIFICATIONS

	$span.click(function() {

		var $this=$(this);

		if(!$this.hasClass('active'))
		{
			$this.addClass('active');
			$activespan.removeClass('active');

			$activespan=$this;

			$p.removeClass($class).addClass($nextclass);

			$class=$nextclass;
			$nextclass=$inter;
			$inter=$class;

			setActive($follow_acts, $your_acts);
		}	
	})

	function setActive($elem, $otherelem)
	{
		if($elem.hasClass('active'))
		{
			$elem.removeClass('active');
			$otherelem.addClass('active');
		}
		else
		{
			$otherelem.removeClass('active');
			$elem.addClass('active');
		}
	}

})