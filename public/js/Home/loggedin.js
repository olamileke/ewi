"use strict"

$(document).ready(function() {

	var $host=location.hostname;

	var $body=$('body');

	var $followbtn=$('.details button');

	function closeMessage()
	{
		var $span=$('.timeline_message span');

		$span.click(function() {

			$(this).parent().remove();
		})
	}

	// FOLLOWING A USER

	$followbtn.click(function() {


		var $this=$(this);

		if($this.text().includes('Unfollow'))
		{
			unFollowFunction($this);
		}
		else
		{
			followFunction($this);
		}
	})



	function followFunction($this)
	{
		var $id=$this.parent().find('span').text();

		$.ajax('/user/follow', {
			type:'POST',
			data:{
				'id':$id
			},
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$this.html('<i class="fas fa-user-check"></i> Unfollow');

				alert(data);

				if(data == 3)
				{
					$body.prepend('<div class="timeline_message"><p>Reload the Page to see your brand new timeline</p><span></span></div>');
					
					closeMessage();
				}
			}
		})
	}


	function unFollowFunction($this)
	{
		var $id=$this.parent().find('span').text();

		$.ajax('/user/unfollow', {
			type:'POST',
			data:{
				'id':$id
			},
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$this.html('<i class="fa fa-user-plus"></i> Follow');

				if(data < 3)
				{
					$('.timeline_message').remove();
				}

				alert(data);
				
			}
		})
	}
})