<!DOCTYPE html>
<html>
    <head>
        <title>Ewi - Login</title>
        <link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/Home/login.css') }}">

        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body>

        <div class='container'>

            <div class='info'>
                
                <p>Poem</p>

                <li>A piece of writing that expresses feelings and ideas</li>
            </div>

            <div class='form-body'>

                @if(Session::has('error'))

                    <div class='alert'>{{ Session::get('error') }}</div>
                @endif

                <form action='{{ route("login") }}' method='POST'>
                    
                    {{ csrf_field() }}

                    <input type="email" name="email" value="{{ old('email') }}" placeholder='Email Address'>

                    <input type="password" name="password" placeholder="Password">

                    <input type="submit" value="Login">

                    <p>Login with</p>

                    <a href="" class='social fb'><img src="{{ asset('Images/Home/facebooksmall.png') }}"> Facebook</a>

                    <a href="" class='social google'><img src="{{ asset('Images/Home/googlesmall.png') }}"> Google</a>

                    <a href="{{ route('social.auth', ['provider'=>'github']) }}" class='social github'><img src="{{ asset('Images/Home/githubsmall.png') }}"> Github</a>

                    <p class='signup'>Don't have an account? <a href="/register">Create one</a></p>

                </form>

            </div>
        </div>


   <!--     <script type="text/javascript" src=" {{ asset('js/jquery-3.2.1.min.js') }} "></script>
        <script type="text/javascript">
            
            alert($('form a ').css('width'));
        </script> -->
    </body>
</html>