<?php
include($_SERVER['DOCUMENT_ROOT']."/plootus/head/connect.php");

if(isset($_POST['fName']) === true & isset($_POST['lName']) === true & isset($_POST['email']) === true & isset($_POST['password']) === true){
	$fName = htmlspecialchars(mysqli_real_escape_string($conStudent, $_POST['fName']));
	$lName = htmlspecialchars(mysqli_real_escape_string($conStudent, $_POST['lName']));
	$email = htmlspecialchars(mysqli_real_escape_string($conStudent, $_POST['email']));
	$password = htmlspecialchars(mysqli_real_escape_string($conStudent, $_POST['password']));
	$ip = $_SERVER['REMOTE_ADDR'];#user ip address
	$date = date("Y-m-d");

	//hashing password
	$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#$%^.";
	$salt = substr(str_shuffle($char), 0, 15);
	$password = $password . $salt;
	$password = password_hash($password, PASSWORD_DEFAULT);

	//check email
	$emailCheck = mysqli_query($conStudent, "SELECT Email FROM Students WHERE Email='$email'");
	$emailRows = mysqli_num_rows($emailCheck);
	if ($emailRows == 0) {

		//creating a unique uid (find a more efficient way)
		do{
			$uid = substr(str_shuffle($char), 0, 20);
			$uidCheck = mysqli_query($conStudent, "SELECT UID FROM Students WHERE UID='$uid'");
			$uidRows = mysqli_num_rows($uidCheck);
		}while($uidRows != 0);

		//enter data in db
		$registering = mysqli_query($conStudent, "INSERT INTO Students (UID,Username,FirstName,LastName,Email,Password,Salt,IP,EmailConfirmed,PhoneConfirmed,SignUpDate,Closed) VALUES ('$uid','$uid','$fName','$lName','$email','$password','$salt','$ip','0','0','$date','0')");
		
		//create session variables
		session_start();
		$_SESSION["UID"] = $uid;
		$_SESSION['Email'] = $email;

		//send confirmation email
		$emailUID = substr($uid, 0, 5) . substr(str_shuffle($char), 0, 10);
		$confirmation = mysqli_query($conStudent, "INSERT INTO IDConfirmation (UID,EmailUID,Date,Confirmed) VALUES ('$uid','$emailUID','$date','0')");

		$subject = "Plootus | Email Confirmation";
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
				<center style='width:100%;'>
					<div style='background: #fff; max-width: 92vw; border: 1px solid #efefef; border-radius: 3px; padding: 2vw; color: #111; text-align:left;'>
						<h2 style='font-family: Raleway, Arial, sans-serif; margin: 0; width: 100%; text-align: center;'>Email Confirmation</h2><br>
						Hi!<br><br>
						Thank you for registering at Plootus.<br>
						To confirm your email address, just click the button below.<br><br>
						<span style='width: 100%; text-align: center;'>
							<a href='http://rayyanq.com/plootus/confirmation/".$emailUID."'>
								<button style='background: #fff; border: 1px solid #1dd1a1; outline: 0; padding: 2vh 2vw; color: #1dd1a1; font-size: 1em; font-weight: bold;'>Confirm my email address</button>
							</a>
						</span>
						<br>
						<br>
						If the button does not work, copy and paste this in the address bar: 'http://rayyanq.com/plootus/confirmation/".$emailUID."'.
					</div>
				</center>
			</body>
		</html>
		";

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <support@hubuddies.com>' . "\r\n"; #change sending email

		mail($email,$subject,$message,$headers);

		echo"<meta http-equiv=\"refresh\" content=\"0; url=http://rayyanq.com/plootus/dashboard\">";
	}
	else {
		echo"An account already exists with this email address";
	}
}
