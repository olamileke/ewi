"use strict"

$(document).ready(function() {

	let $tabs=$('ul.tabs li');

	let $tabsarray=['about','poems','following','followers'];


	// DETERMINING THE SUB-VIEW TO DISPLAY WHETHER ABOUT, POEMS, FOLLOWING OR FOLLOWERS

	$tabs.click(function() {
		
		let $this=$(this);

		if(!$this.hasClass('active'))
		{
			let $class=$this.attr('class');
			$this.addClass('active');
			toggleDisplayedView($class);
		}
	})


	function toggleDisplayedView($class)
	{
		for(let $i=0; $i < $tabsarray.length ; $i++)
		{
			if($tabsarray[$i] == $class)
			{
				$(`div.${$class}`).addClass('active').show();
			}
			else
			{
				$(`div.${$tabsarray[$i]}`).removeClass('active').hide();
				$(`li.${$tabsarray[$i]}`).removeClass('active');
			}
		}
	}


	// TRIGGERING THE FILE DIALOG TO CHANGE THE OVERLAY IMAGE

	let $changebtn=$('button.change-overlay');

	let $overlayimg=$('img.back-img');

	let $filebtn=$('input[type="file"]');

	$changebtn.click(function() {
		$filebtn.click();
	})


	setInterval(function() {

		if($filebtn.prop('files').length > 0)
		{
			let $form=new FormData();

			$form.append('overlay', $filebtn.prop('files')[0]);

			$.ajax('/user/overlay/change', {
				type:'POST',
				processData:false,
				contentType:false,
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:$form,
				error:function(data) {
					console.log(data.responseText);
				},
				success:function(data) {
					$filebtn.val("");

					$overlayimg.attr('src',data);
				}
			})
		}
	}, 2000)
})