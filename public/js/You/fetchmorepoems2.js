"use strict"

$(document).ready(function() {

	let $tagcount=$('.tagcount').text();

	let $poemscontainer=$('.poems');

	let $loaderbody=$('.lds-css');

	let $tag=document.URL.split('/tag/')[1];

	let $page=2;

	// DETERMINING WHEN THE USER IS AT THE BOTTOM OF THE PAGE

	$(window).scroll(function() {

		let $doc_height=$(document).height();

		let $scrollHeight=$(window).height() + $(window).scrollTop();

		if(( $doc_height - $scrollHeight ) / $doc_height === 0)
		{
			if($tagcount > $('.poem').length)
			{
				fetchMorePoems();
			}
		}

	})


	// FUNCTION TO LOAD MORE POEMS INTO THE POEM CONTAINER

	function fetchMorePoems()
	{

		setTimeout(function() {

			$loaderbody.show();
		},2000)


		setTimeout(function() {
			$.ajax(`/tag/fetchmorepoems/${$tag}/8?page=${$page}`, {
			type:'POST',
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			error:function(data) {
				console.log(data.responseText);
			},
			success:function(data) {
				$poemscontainer.append(data);

				$page++;

				$loaderbody.hide();
			}
		 })
		}, 4000)	
	}

})