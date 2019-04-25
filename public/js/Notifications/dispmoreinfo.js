

let $body=$('body');

let $infocontainer=$(".InfoContainer");

let $infodiv=$infocontainer.find('.info');

let $infobtn=$('.view');

let $closebtn=$infocontainer.find('.closebtn');

$infobtn.click(function() {

	$body.toggleClass('noscroll');
	$infocontainer.show();

	let $this=$(this);

	let $parent=$this.parent();

	let $id=$parent.find('.action_id').text();

	alert($parent.find('.action_id').html());

	
	alert($id);

	if($parent.text().includes('reviewed'))
	{
		getReview($id);
	}
})


// GETTING THE REVIEW OR COMMENT

function getReview($id)
{
	$infodiv.html(`<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`);

	$.ajax(`/action/getreview/${$id}`, {
		type:'POST',
		headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
		error:function(data) {
			console.log(data.responseText);
		},
		success:function(data) {
			$infodiv.html(data)
		}
	})
}

// CLOSING THE EXTRA INFORMATION DIALOG

$closebtn.click(function() {
	$infocontainer.hide();
	$body.toggleClass('noscroll');
})
