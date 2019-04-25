"use strict"

$(document).ready(function() {

	let $replybtn=$('.replybtn');

	let $body=$('body');

	let $replybackground=$('.reply_background');

	let $reply_container=$replybackground.find('.reply_container');

	let $textarea;

	let $replyto;

	let $id;

	// TOGGLING THE DIALOG TO DISPLAY THE COMMENT 

	$replybtn.click(function() {
		$body.addClass('noscroll');
		$replybackground.show();
		$reply_container.html(`
								<div class='closebtn'>
									<span></span>
								</div>
								<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`);

		let $this=$(this);
		$id=$this.parent().find('.comment_id').text();

		$replyto=$this.parent().parent().find('.replycontainer');

		getComment();
	})


	// FETCHING THE COMMENT

	function getComment()
	{
		return $.ajax(`/comment/display/${$id}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			success:function(data) {
				$reply_container.html(data);

				let $logreplybtn=$('.logreply');

				let $closebtn=$reply_container.find('.closebtn');

				$textarea=$reply_container.find('textarea');

				$logreplybtn.click(function() {
					logReply($(this));
				})

				$closebtn.click(function() {
					closeDialog();
				})

				$textarea.keyup(function() {

					if($textarea.val())
					{
						$textarea.css('border','1px solid rgba(0,0,0,0.35)');
						return true;
					}

					$textarea.css('border', '1px solid rgba(255,0,0,0.39)');

				})
			}
		})
	}

	// REPLYING TO THE COMMENT

	function logReply($elem)
	{
		if(!$textarea.val())
		{
			$textarea.css('border','1px solid rgba(255,0,0,0.39)');

			return false;
		}	

		$.ajax('/comment/reply', {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{
				'reply':$textarea.val(),
				'id':$id
			},
			error:function(data) {
				console.log(data.responseText);
			},
			success:function(data) {

				closeDialog();
				toastr.success('Reply posted');
				$reply_container.find('img').addClass('move-down');
				$elem.prop('disabled',true).css('cursor','none');

				$replyto.append(data);
			}
		})
	}


	// FUNCTION TO CLOSE THE REPLY DIALOG

	function closeDialog()
	{
		$replybackground.hide();
		$reply_container.find('img').removeClass('move-down');
		$body.removeClass('noscroll');
	}



})