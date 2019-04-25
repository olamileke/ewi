"use strict"

$(document).ready(function() {

	//FOLLOWING A USER ON THE HOME PAGE

	var $followbtn=$('.follows button');


	$followbtn.click(function() {	

		let $this=$(this);

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
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'id':$id
			},
			success:function(data) {
				$this.html('<i class="fas fa-user-check"></i> Unfollow');				
			}
		})
	}


	function unFollowFunction($this)
	{
		var $id=$this.parent().find('span').text();

		$.ajax('/user/unfollow', {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'id':$id
			},
			success:function(data) {
				$this.html('<i class="fa fa-user-plus"></i> Follow');							
			}
		})
	}
})