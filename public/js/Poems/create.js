"use strict"


$(document).ready(function() {

	var $host=location.hostname;

	// CREATING NEW TAGS

	var $x=$('p i.fa-times');

	var $body=$('body');

	var $tagbtn=$('.tagbtn');

	var $new_tag_body=$('.new_tag');

	var $span=$new_tag_body.find('span');

	var $new_tag_btn=$new_tag_body.find('button.add');

	var $new_input=$new_tag_body.find('input');

	var $tagbody=$('.tags');

	var $buttonclose=$('button.close');


	$x.click(function() {

		$(this).parent().remove();
	})

	$tagbtn.click(function() {

		$body.addClass('noscroll');		
		$new_tag_body.show();
	})


	// CLOSING THE NEW TAG DIALOG

	$buttonclose.click(function() {
		$body.removeClass('noscroll');		
		$new_tag_body.hide();
		$new_input.val("");
	})

	$new_tag_btn.click(function() {

		var $text=$new_input.val();
		if(!$text)
		{
			$new_input.css('border', '1px solid #FF9999');
		}
		else
		{
			$new_tag_body.hide();
			$body.removeClass('noscroll');	
			$tagbody.append('<p>'+$text+'<i class="fa fa-times"></i></p>').append('<input type="checkbox" name="tags[]" value="'+$text+'" checked hidden>');
			$new_input.val("");
		}	
	})


	$new_input.keyup(function() {
		if($(this).val())
		{
			$(this).css('border','1px solid rgba(0,0,0,0.02)');
		}
	})


	// AUTOMATICALLY DISPLAYING THE PICTURE

	var $image=$('input[type="file"]');

	var $picturediv=$('.picture div.image');

	var $imagepath;

	var $comparepath='null';

	var $inputimage=$('.imagepath');

	function uploadImage($current)
	{
		if($current != $comparepath)
		{
			$picturediv.html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>').css('background','none');

			var $formData=new FormData();

			$formData.append('image', $image.prop('files')[0]);

			$comparepath=$image.prop('files')[0].name;

			return $.ajax('/poem/picture/upload', {
				type:'POST',
				processData:false,
				contentType:false,
				data:$formData,
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				success:function(data) {
					
					$imagepath=data;
					$picturediv.css({'background':"url(http://"+$host+"/Images/Poems/"+$imagepath+")",'background-size':'cover', 'background-position':'15% 0'}).html("");
					
					$inputimage.val($imagepath);

					clearInterval($interval);					

					$interval=setInterval(function() {
			
						if($image.prop('files').length > 0)
						{
							uploadImage($image.prop('files')[0].name);
						}

						}, 2000)				
					}
				})
		}
	}


	var $interval=setInterval(function() {
		
			if($image.prop('files').length > 0)
			{
				uploadImage('');
			}

		}, 2000)

})