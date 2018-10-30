<?php
include($_SERVER['DOCUMENT_ROOT']."/plootus/head/connect.php");

if(isset($_POST['email_phone']) === true){
	$email_phone = $_POST['email_phone'];
	$ip = $_SERVER['REMOTE_ADDR'];#user ip address
	$date = date("Y-m-d");

	//get User ID
	$UserCheck = mysqli_query($conStudent, "SELECT Email, UID FROM Students WHERE (Email='$email_phone' OR Phone='$email_phone') AND Closed='0'");
	$row = mysqli_fetch_assoc($UserCheck);
	$email = $row['Email'];
	$uid = $row['UID'];

	//Enter into DB
	$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#$%";
	$forgotUID = substr(str_shuffle($char), 0, 10);
	$forgot = mysqli_query($conStudent, "INSERT INTO Forgot (UID,ForgotUID,RequestIP,RequestDate,Used) VALUES ('$uid','$forgotUID','$ip','$date','0')");

	//Send Email
	$subject = "Password Reset | Plootus";
	$message = "
	<html>
		<head>
			<style type='text/css'>
				@import url('https://fonts.googleapis.com/css?family=Nunito:400,700');
				@import url('https://fonts.googleapis.com/css?family=Raleway:700');
			</style>
		</head>
		<body style='margin: 0; background: #fff; font-family: Nunito, sans-serif, Arial; color: #444444;'>
			<header style='padding: 3vh 2vw;'>
				<h1 style='font-family: Raleway, Arial, sans-serif; margin: 0;'>
					<a href='http://rayyanq.com/plootus' style='text-decoration:none; color: #1dd1a1;'>Plootus</a>
				</h1>
			</header><br>
			<div style='background: #fff; max-width: 92vw; border: 1px solid #efefef; border-radius: 3px; padding: 2vw; color: #111; text-align:left;'>
				<h2 style='font-family: Raleway, Arial, sans-serif; margin: 0; width: 100%; text-align: center;'>Password Reset</h2><br>
				To reset your password click the button below<br><br>
				<center style='width: 100%;'>
					<a href='http://rayyanq.com/plootus/forgot/".$forgotUID."'>
						<button style='background: #fff; border: 1px solid #1dd1a1; outline: 0; padding: 2vh 2vw; color: #1dd1a1; font-size: 1em; font-weight: bold; margin: auto;'>Confirm my email address</button>
					</a>
				</center>
				<br>
				<br>
				If the button does not work, copy and paste this in the address bar: 'http://rayyanq.com/plootus/forgot/".$forgotUID."'.<br><br>
				If you did not request to reset your password, you can safely ignore this message.
			</div>
		</body>
	</html>
	";

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <support@hubuddies.com>' . "\r\n"; #change sending email

	mail($email,$subject,$message,$headers);

	echo"A reset link has been sent to you email address";
}