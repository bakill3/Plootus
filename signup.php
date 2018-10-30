<?php
	session_start();
	if(isset($_SESSION['UID'])){
		header("Location: http://rayyanq.com/plootus/dashboard");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GreenEd</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="http://rayyanq.com/plootus/css/signup.css">
		<script type="text/javascript" src="http://rayyanq.com/plootus/js/jquery.js.gz"></script>
		<script type="text/javascript">
			$(document).ready(function(){

				//login form
				$("#signup").on("submit", function(event){
					event.preventDefault();
					var fName = $("#fName").val();
					var lName = $("#lName").val();
					var email = $("#email").val();
					var password = $("#password").val();
					if(password.length > 5){
						$.post('http://rayyanq.com/plootus/ajax/signup.php',{fName:fName,lName:lName,email:email,password:password},function(data){
							$('#error').html(data);
						});
					}
					else{
						$('#error').html("Your password must contain atleast 6 characters.");
					}
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
				<h2>Sign Up</h2><br>
				<form method="post" id="signup">
					<input type="text" class="txt" id="fName" placeholder="First Name*" required="required"><br>
					<input type="text" class="txt" id="lName" placeholder="Last Name*" required="required"><br>
					<input type="email" class="txt" id="email" placeholder="Email*" required="required"><br>
					<input type="password" class="txt" id="password" placeholder="Password*" required="required"><br>
					<b id="error"></b><br>
					<a href="http://rayyanq.com/plootus/login">Already have an account?</a><br>
					<input type="submit" value="Submit" class="submit">
				</form>
			</div>
		</div>
	</body>
</html>