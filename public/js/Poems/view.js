"use strict"

$(document).ready(function() {

	var $id=$('p.id').text();

	var $favbtn=$('button.favorite');

	var $count=0;

	var $slug=document.URL.split('/poem/')[1];

	let $host=location.hostname;

	// //READING A POST

	// var $read_interval=setInterval(function() {

	// 	if($count == 31)
	// 	{
	// 		$.ajax('/user/read', {
	// 			type:'POST',
	// 			data:{
	// 				'slug':$slug
	// 			},
	// 			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}
	// 		})
	// 	}

	// 	$count++;

	// },1000)


	// SENDING THE AJAX REQUESTS TO FAVORITE POSTS

	$favbtn.click(function() {

		let  $this=$(this);		
		let $id=$this.parent().find('span').text();

		if($this.html().trim().startsWith('Favorite'))
		{
			$.ajax(`/favorite/${$id}`, {
				type:'POST',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				success:function(data) {
					$this.html("Unfavorite <i class='fas fa-star'></i>");
				}
			})
		}
		else
		{
			$.ajax(`/unfavorite/${$id}`, {
				type:'POST',				
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				success:function(data) {

					$this.html("Favorite <i class='far fa-star'></i>");
				}
			})
		}

	})


	// HIGHLIGHTING THE RATING STARS

	var $stars=$('#review .container i.fa-star');

	var $textarea=$('#review textarea');


	// CHECKING IF THE STARS WILL HAVE THE HOVER EVENT NEEDED TO RATE

	var $hasEvent='false';

	function checkIfRated()
	{
		return $.ajax('/poem/checkrated', {
			type:'POST',
			data:{
				'slug':$slug
			},			
		  	headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
		  	success:function(data) {
		  		
		  		if(data != 'true')
		  		{
		  			$hasEvent='true';

		  			$stars.hover(function() {

		  				setRating($(this));
		  			}, function(){})
		  		}
		  	}
		})
	}

	checkIfRated();

	function setRating($elem)
	{
		$elem.prevAll().addBack().removeClass('far').addClass('fas');
		$elem.nextAll().removeClass('fas').addClass('far');
	}

	// CARRYING OUT VALIDATION ON THE REVIEW TEXTAREA

	$textarea.keyup(function() {
		if(!$(this).val())
		{
			$textarea.css('border', '1px solid #FF9999');			
		}
		else
		{
			$textarea.css('border', '1px solid rgba(0,0,0,0.22)');
		}
	})


	// REVIEWING POSTS

	var $reviewbtn=$('#review button');

	var $ratingsval;

	$reviewbtn.click(function() {

		var $this=$(this);

		var $commentscontainer=$('.commentscontainer');

		// A BIT OF VALIDATION

		if($textarea.val())
		{

			if($hasEvent == 'true')
			{
				$ratingsval=$('#review i.fas').length;
			}
			else
			{
				$ratingsval=0;
			}

			$.ajax('/poem/review', {
				type:'POST',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:{
					'slug':$slug,
					'comment':$textarea.val(),
					'rating':$ratingsval
				},
				error:function(data) {
					console.log(data.responseText);
				},
				success:function(data) {
					
					// HIDING THE REVIEW DIALOG

					$('.blocker').hide();

					toastr.success('Review posted');

					$('body').css('overflow-y', 'scroll');

					$commentscontainer.append(data);

					// CREATING THE LIKE AND UNLIKE ACTIONS 

					var $hearts=$('div.comment i.fa-heart');

					$hearts.click(function() {

						likeAndUnlikeAction($(this));		
					})				

					if($ratingsval > 0)
					{
						$stars.off();
					}
				}
			})
		}
		else
		{
			$textarea.css('border', '1px solid #FF9999');
		}
	})


	// LIKING  AND UNLIKING COMMENTS

	var $hearts=$('div.comment i.fa-heart');

	$hearts.click(function() {

		likeAndUnlikeAction($(this));		
	})

	// HELPER FUNCTION TO ACTUALLY DO THE LIKING AND UNLIKING

	function likeAndUnlikeAction($elem)
	{
		var $id=$elem.parent().find('.id').text();

		var $span=$elem.parent().find('span.likes-count');

		if($elem.hasClass('far'))
		{
			$elem.removeClass('far').addClass('fas');

			$.ajax('/comment/like', {
				type:'POST',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:{
					'comment_id':$id
				},
				success:function(data) {
					$span.text(data);
				}
			})
		}
		else
		{
			$elem.removeClass('fas').addClass('far');

			$.ajax('/comment/unlike', {
				type:'POST',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				data:{
					'comment_id':$id
				},
				success:function(data) {
					$span.text(data);
				}
			})
		}
	}

	// REPLYING COMMENTS

	var $replybtn=$('div.comment button');

	$replybtn.click(function() {
		
	})


	// FETCHING MORE COMMENTS VIA AN AJAX CALL

	let $commentscontainer=$('div.commentscontainer');

	let $morecommentsbtn=$('div.commentscontainer + button');

	let $commentpage=2;

	let $numcomments=$('span.total_comments').text();

	$morecommentsbtn.click(function() {

		if($numcomments.trim() >= $('.comment').length)
		{
			let $this=$(this);

			$this.html(`Load More <img src="http://127.0.0.1:8000/Images/Comments/ring.png">`).css('paddingBottom','8px');

			$.ajax(`/comments/fetchMore/${$slug}/3?page=${$commentpage}`, {
				type:'POST',
				headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
				error:function(data) {
					console.log(data.responseText);
				},
				success:function(data) {
					
					setTimeout(function() {

						$commentscontainer.append(data);

						$this.find('img').remove().css('paddingBottom','6px');

						$hearts=$('div.comment i.fa-heart');

						$hearts.click(function() {

							likeAndUnlikeAction($(this));		
						})

						if($numcomments.trim() == $hearts.length)
						{
							$this.remove();
						}

						$commentpage++;

					},2000)
				}
			})
		}
	})
})