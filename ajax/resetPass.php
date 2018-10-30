<?php
include($_SERVER['DOCUMENT_ROOT']."/plootus/head/connect.php");

if(isset($_POST['uid']) === true & isset($_POST['pass']) === true){
	$uid = $_POST['uid'];
	$password = $_POST['pass'];
	$ip = $_SERVER['REMOTE_ADDR'];#user ip address
	$date = date("Y-m-d");

	//hashing password
	$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#$%^.";
	$salt = substr(str_shuffle($char), 0, 15);
	$password = $password . $salt;
	$password = password_hash($password, PASSWORD_DEFAULT);

	//get user id
	$forgotCheck = mysqli_query($conStudent, "SELECT UID FROM Forgot WHERE ForgotUID='$uid' AND Used='0'");
	$row = mysqli_fetch_assoc($forgotCheck);
	$UserID = $row['UID'];

	//Update DBs
	$updatePass = mysqli_query($conStudent, "UPDATE Students SET Password='$password', Salt='$salt' WHERE UID='$UserID'");
	$updateForgot = mysqli_query($conStudent, "UPDATE Forgot SET ChangeIP='$ip', ChangeDate='$date', Used='1' WHERE ForgotUID='$uid' AND UID='$UserID' AND Used='0'");

	echo"<meta http-equiv=\"refresh\" content=\"0; url=http://rayyanq.com/plootus/login\">";
}