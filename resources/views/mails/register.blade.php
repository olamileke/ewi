<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>

			<div style='position:relative;left:20vw;width:60vw;background:rgba(0,0,0,0.03);top:10vh'>
				
				<div style='position:relative; left:15%; width:70%; padding:2vw 0 4vw 0;background:#fff; display:flex; flex-flow:column; align-items: center'>
					
					<p style='font-family:"New Times Roman", sans-serif; font-size:2em; color:rgba(18,97,160,0.8);margin-left:-3px; margin-bottom:-1px'>EWI</p>

					<p style='width:75%; line-height:1.8; font-family:"Trebuchet MS", sans-serif; color:rgba(0,0,0,0.7)'>Hello {{ $user->name }}. Welcome to Ewi, home to connoisseurs and lovers of good poetry. Kindly
					click this link to activate your account.
					</p>

					<a href="{{ route('account.activate', ['token'=>$token]) }}" style='text-decoration:none; color:#fff; padding:11px; border-radius:5px; background:rgba(56,149,211, 0.7)'>Activate</a>
				</div>
			</div>
	</body>
</html>