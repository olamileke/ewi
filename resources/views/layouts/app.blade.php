<!DOCTYPE html>
<html>
	<head>		
		<title>@yield('page_title')</title>	

		<link rel="stylesheet" type="text/css" href="{{ asset('css/Layouts/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css\Poems\loader.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css') }}">		
		<link rel="stylesheet" type="text/css" href="{{ asset('css/Toastr/toastr.min.css') }}">
		<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 

		@yield('page_css')

	</head>
	<body>
		   <header>
            
	            <div class='page_title'>
	            	<div class='navtoggle'>
	            		<span></span> 
	            	</div>

	            	<a href='/'>EWI</a>
	            	<form action='/search' method='GET' class='search-lg'>
		                <input type="text" name="q" value="{{ $searchterm or '' }}" placeholder='Find People, Poetry, Tags'>
		            </form>	
	            </div>

	            <div class='profile sm'>
	                <div style='background:url({{ Auth::user()->avatar }}); background-size:cover; background-repeat:no-repeat;'></div>

	                <p>{{ Auth::user()->name }}</p>

	                <i class='fa fa-caret-down'></i>

	            </div>

	            <ul class='actions'>
                	<span class='close'></span>

                	<li>
                		<a href="{{ route('profile', ['name'=>Auth::user()->getNameSlug()]) }}">Profile</a>
                		<p class='indicator' align="right"></p>
                	</li>
                	<li>
                		<a href="#">Favourites</a>
                		<p class='indicator'></p>
                    </li> 	
                    <li>
                		<a href="{{ route('tag.view', ['name'=>Auth::user()->getNameSlug() ]) }}">Tags</a>
                		<p class='indicator'></p>
                    </li>  
                	<li>
                		<a href="#">Settings</a>
                		<p class='indicator'></p>                		
                	</li>  	
                	<li>
                		<a href="/logout">Logout</a>
                		<p class='indicator'></p>                		
                	</li>
                </ul>

	            <ul class='sidebar'>
	            	<span class='sidebar'></span>

	            	<li>
	            		<form action='/search' method='GET' class='search-sm' hidden>
			                <input type="text" name="q" value="{{ $searchterm or '' }}" placeholder='Find People, Poetry, Tags'>
			            </form>	
	            	</li>

	                <li>
	                    <a href="/">Feed</a>
	                    <p class='indicator'></p>
	                </li>
	                 <li>
	                    <a href="{{ route('poem.create') }}">Create</a>
	                    <p class='indicator'></p>
	                </li>
	                <li>
	                    <a href="/explore">Explore</a>
	                    <p class='indicator'></p>
	                </li> 
	                <li class='notif'>
	                    <a href="/notifications">
	                    	<i class='fa fa-bell'></i>
	                    </a>
	                    <p class='indicator'></p>
	                </li>
	                <li>
	                	<div class='profile lg'>
			                <div style='background:url({{ Auth::user()->avatar }}); background-size:cover; background-repeat:no-repeat;'></div>

			                <p>{{ Auth::user()->name }}</p>

			                <i class='fa fa-caret-down'></i>

			                <ul>
			                	<li>
			                		<a href="{{ route('profile', ['name'=>Auth::user()->getNameSlug()]) }}">Profile</a>
			                	</li>
			                	<li>
			                		<a href="#">Favourites</a>
			                	</li>
			                	 <li>
			                		<a href="{{ route('tag.view', ['name'=>Auth::user()->getNameSlug()]) }}">Tags</a>
			                	</li>
			                	<li>
			                		<a href="/settings">Settings</a>
			                	</li>  	
			                	<li>
			                		<a href="/logout">Logout</a>
			                	</li>
			                </ul>
			            </div>
	                </li>
	            </ul>

	          
        </header>

        @yield('page_body')

		<div class="lds-css ng-scope" hidden><div style="width:100%;height:100%" class="lds-dual-ring"><div></div></div>



    	<script src="{{ asset('js/app.js') }}"></script>
    	<script type="text/javascript" src="{{ asset('js/Toastr/toastr.min.js') }}"></script>
    	<script>
    		toastr.options = {
			  'closeButton':true,
			  "fadeIn": 300,
			  "fadeOut": 1000,
			  "timeOut": 12000,
			  "extendedTimeOut": 1000
			}

			@if(Session::has('success'))
	        	toastr.success("{{ Session::get('success') }}");
	        @endif

	         @if(Session::has('info'))
	            toastr.info("{{ Session::get('info') }}");
	        @endif
    	</script>
    	<script type="text/javascript" src='{{ asset("js/Layouts/app.js") }}'></script>
        @yield('page_js')
	</body>
</html>