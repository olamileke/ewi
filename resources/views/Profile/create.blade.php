<!DOCTYPE html>
<html>
    <head>
        <title>Create Profile</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/Profile/create.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet"> 
    </head>
    <body>

     

        <div class='container'>
            
            <!-- <div class='message'>
                Hey {{ Auth::user()->name }}
            </div> -->

            <form action="{{ route('profile.create') }}" method='POST'>
                
                {{ csrf_field() }}

                <div class='types'>
                	<p>What types of poetry do you enjoy?</p>
                    @foreach($types as $type)

                      <p>  <input type="checkbox" name="types[]" value="{{ $type->id }}"> {{ $type->type }}</p>
                    @endforeach
                </div>

                <p class='about'>Tell us a bit about yourself</p>

                <textarea name='aboutme' rows='8' cols='15'>
                	Make it as explicit as possible, we really want to know you
                </textarea>

                <input type="submit" value='Submit'>

            </form>
        </div>

<!-- 
        <script type="text/javascript" src=" {{ asset('js/jquery-3.2.1.min.js') }} "></script>
        <script type="text/javascript">
            
            alert($('header').css('height'));
        </script> -->
    </body>
</html>