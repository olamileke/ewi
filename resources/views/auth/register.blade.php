<!DOCTYPE html>
<html>
    <head>
        <title>Ewi - Signup</title>     
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/Home/signup.css') }}">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body>

        <div id='container'>            

                <div class='form-body'>

                    @if(Session::has('success'))

                        <div class='alert success'> {{ Session::get('success') }} </div>
                    @endif

                    <!-- <div class='alert success'> {{ Session::get('success') }} My name is Leke</div>  -->
                    <form action='{{ route("register") }}' method='POST'>

                        <p>Ewi</p>

                        {{ csrf_field() }}

                        <input type="text" name="name" placeholder='Full Name'>

                        <input type="email" name="email" placeholder="Email Address">

                        <input type="password" name="password" placeholder='Password'>

                        <input type="submit" value="Signup">

                        <p class='or'>or Continue with</p>

                        <div>
                            <a href="{{ route('social.auth', ['provider'=>'facebook']) }}"><img src="{{ asset('Images/home/facebook.png') }}"></a>
                            <a href=""><img src="{{ asset('Images/home/google.png') }}"></a>
                            <a href="{{ route('social.auth', ['provider'=>'github']) }}"><img src="{{ asset('Images/home/github.png') }}"></a>
                        </div>

                        <div class='login'>Already have an account? <a href='/login'>Login</a></div>
                    </form> 

                </div>

        </div>


        <script type="text/javascript" src='{{ asset("js/jquery-3.2.1.min.js") }}'></script>
        <script type="text/javascript" src='{{ asset("js/particles.js/particles.min.js") }}'></script>
        <script type="text/javascript">

            particlesJS('container', {
                "particles":{
                    "number":{
                        "value":100,
                    },
                    "opacity":{
                        "value":"0.5",
                    },
                    "size":{
                        "value":"5",
                    },
                    "move":{
                        "bounce":true
                    }
                },
                "interactivity":{
                    "events":{
                        "onhover":{
                            "mode":"grab"
                        }
                    }
                }
            });
        </script>
    </body>
</html>