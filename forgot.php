<?php
include($_SERVER['DOCUMENT_ROOT']."/plootus/head/connect.php");
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

				//reset form
				$("#reset").on("submit", function(event){
					event.preventDefault();
					var uid = $(this).data("uid");
					var pass1 = $("#password1").val();
					var pass2 = $("#password2").val();
					if(pass1 == pass2){
						$.post('http://rayyanq.com/plootus/ajax/resetPass.php',{uid:uid,pass:pass1},function(data){
							$('#msg').html(data);
						});
					}
					else{
						$('#msg').html("The passwords don't match.");
					}
				});

				//forgot form
				$("#forgot").on("submit", function(event){
					event.preventDefault();
					var email_phone = $("#email_phone").val();
					$.post('http://rayyanq.com/plootus/ajax/forgotPass.php',{email_phone:email_phone},function(data){
						$('#msg').html(data);
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
			<?php
			if (isset($_GET['uid'])){
				$uid = $_GET['uid'];
				$forgotCheck = mysqli_query($conStudent, "SELECT UID FROM Forgot WHERE ForgotUID='$uid' AND Used='0'");
				if (mysqli_num_rows($forgotCheck)==1) {
					?>
					<div class="card">
						<h2>Reset password</h2><br>
						<form method="post" id="reset" data-uid="<?php echo $uid;?>">
							<input type="password" class="txt" id="password1" placeholder="Enter a new password*" required="required"><br>
							<input type="password" class="txt" id="password2" placeholder="Re-enter the password*" required="required"><br>
							<b id="msg"></b><br>
							<span>
								<a href="http://rayyanq.com/plootus/login">Login</a> | <a href="http://rayyanq.com/plootus/signup">Sign Up</a>
							</span><br>
							<input type="submit" value="Submit" class="submit">
						</form>
					</div>
					<?php
				}
				else{
					header("Location: http://rayyanq.com/plootus/login");
				}
			}
			else{
				?>
				<div class="card">
					<h2>Reset password</h2><br>
					Please enter your registered email address or mobile number.<br><br>
					<form method="post" id="forgot">
						<input type="text" class="txt" id="email_phone" placeholder="Email/Phone*" required="required"><br>
						<b id="msg"></b><br>
						<span>
							<a href="http://rayyanq.com/plootus/login">Login</a> | <a href="http://rayyanq.com/plootus/signup">Sign Up</a>
						</span><br>
						<input type="submit" value="Submit" class="submit">
					</form>
				</div>
				<?php
			}
			?>
		</div>
	</body>
</html>