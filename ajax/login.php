<?php
include($_SERVER['DOCUMENT_ROOT']."/plootus/head/connect.php");

if(isset($_POST['email_phone']) === true & isset($_POST['password']) === true ){
	$email_phone = $_POST['email_phone'];
	$password = $_POST['password'];

	//Get username, password, and salt
	$userquery = mysqli_query($conStudent, "SELECT UID,Email,Password,Salt FROM Students WHERE (Email='$email_phone' OR Phone='$email_phone') AND Closed='0'");
	$userCount = mysqli_num_rows($userquery);

	if($userCount == 1){ #check if user exists
		$row = mysqli_fetch_assoc($userquery);
		$email = $row["Email"];
		$uid = $row["UID"];
		$salt = $row["Salt"];
		$hash = $row['Password'];
		$password = $password . $salt;

		if(password_verify($password, $hash)){ #check password
			session_start();
			//set session variables
			$_SESSION['UID'] = $uid;
			$_SESSION['Email'] = $email;
			echo"<meta http-equiv=\"refresh\" content=\"0; url=http://rayyanq.com/plootus/dashboard\">";
		}
		else
		{
			echo 'The email and/or password is incorrect.';
		}

	}
	else
	{
		echo 'The email and/or password is incorrect.';
	}
}