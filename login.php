<?php
	session_start();
	if(isset($_SESSION['UID'])){
		header("Location: http://rayyanq.com/plootus/dashboard");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Plootus</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="http://rayyanq.com/plootus/css/signup.css">
		<script type="text/javascript" src="http://rayyanq.com/plootus/js/jquery.js.gz"></script>
		<script type="text/javascript">
			$(document).ready(function(){

				//login form
				$("#login").on("submit", function(event){
					event.preventDefault();
					var email_phone = $("#email_phone").val();
					var password = $("#password").val();
					$.post('http://rayyanq.com/plootus/ajax/login.php',{email_phone:email_phone,password:password},function(data){
						$('#error').html(data);
					});
				});

			});
		</script>
	</head>
	<body>
		<header>
			<h1 id="logo"><a href="http://rayyanq.com/plootus">Plootus</a></h1>
		</header>	
		<div id="body">
			<div class="card">
				<h2>Log In</h2><br>
				<form method="post" id="login">
					<input type="email" class="txt" id="email_phone" placeholder="Email/Phone*" required="required"><br>
					<input type="password" class="txt" id="password" placeholder="Password*" required="required"><br>
					<b id="error"></b><br>
					<span>
						<a href="http://rayyanq.com/plootus/forgot">Forgot password?</a> | <a href="http://rayyanq.com/plootus/signup">Create account</a>
					</span><br>
					<input type="submit" value="Submit" class="submit">
				</form>
			</div>
		</div>
	</body>
</html>