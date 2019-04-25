("use strict")

$(document).ready(function() {


	let $poemscontainer=$('.poems');

	let $loaderbody=$('.lds-css');

	let $spanmore=$poemscontainer.find('span.more');

	let $page=2;

	let $type=document.URL.split('type/')[1];

	// THIS VARIABLE IS USED TO DETERMINE IF WE ARE ON THE HOME/FEED PAGE OR IF WE ARE ON THE TYPES PAGE

	let $urlDeterminer=document.URL.includes('type');

	// DETERMINING IF THE USER IS AT THE END OF THE PAGE AND LOADING MORE POEMS

	$(window).scroll(function() {

		let $doc_height=$(document).height();

		let $scrollHeight=$(window).height() + $(window).scrollTop();

		if(( $doc_height - $scrollHeight ) / $doc_height === 0)
		{
			if($spanmore.text().trim() > $('.poem').length)
			{
				fetchMorePosts();
			}
		}

	})


	// FUNCTION TO GRAB MORE POSTS

	function fetchMorePosts()
	{
		setTimeout(function(){
				$loaderbody.show();
		}, 3000)

		setTimeout(function() {

			if($urlDeterminer)
			{
				grabTypePosts();			
			}
			else
			{
				grabFeedPosts();
			}

		}, 6000)
	}

	// LOADING MORE POSTS ON THE FEED/HOME PAGE

	function grabFeedPosts()
	{
		$.ajax(`/poem/fetchmore/4?page=${$page}`, {
				type:'GET',
			error:function(data) {
				console.log(data.responseText);
			},
			success:function(data) {
				$poemscontainer.append(data);

				if($spanmore.text().trim() == $('.poem').length)
				{
					$loaderbody.remove();
				}
				else
				{
					$loaderbody.hide();
				}

				$page++;
			}
		})
	}


	// LOADING MORE POSTS ON THE TYPES PAGE

	function grabTypePosts()
	{
		$.ajax(`/type/fetchmore/10?page=${$page}`, {
				type:'POST',
				error:function(data) {
					console.log(data.responseText);
				},
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:{
					'type':$type
				},
				success:function(data) {
					$poemscontainer.append(data);

					if($spanmore.text().trim() == $('.poem').length)
					{
						$loaderbody.remove();
					}
					else
					{
						$loaderbody.hide();
					}

					$page++;
				}
			})
	}



})