<?php
include($_SERVER['DOCUMENT_ROOT']."/plootus/head/connect.php");
session_start();

if(isset($_GET['uid'])){ #if uid is given
	$confirmationID = htmlspecialchars(mysqli_real_escape_string($conStudent, $_GET['uid']);
	$uidCheck = mysqli_query($conStudent, "SELECT UID,EmailUID,PhoneUID FROM IDConfirmation WHERE (EmailUID='$confirmationID' OR PhoneUID='$confirmationID') AND Confirmed='0'");
	$uidRows = mysqli_num_rows($uidCheck);
	if($uidRows==1){ #check if it exists in the DB

		$row = mysqli_fetch_assoc($uidCheck);
		$uid = $row['UID'];
		$emailUID = $row['EmailUID'];
		$phoneUID = $row['PhoneUID'];

		//Update DB
		$confirmed = mysqli_query($conStudent, "UPDATE IDConfirmation SET Confirmed='1' WHERE (EmailUID='$confirmationID' OR PhoneUID='$confirmationID') AND UID='$uid' AND Confirmed='0'");
		if($confirmationID == $emailUID){
			$confirmed2 = mysqli_query($conStudent, "UPDATE Students SET EmailConfirmed='1' WHERE UID='$uid'");
		}
		else if($confirmationID == $phoneUID){
			$confirmed2 = mysqli_query($conStudent, "UPDATE Students SET PhoneConfirmed='1' WHERE UID='$uid'");
		}

		if(isset($_SESSION['UID'])){
			header("Location: http://rayyanq.com/plootus/dashboard");
		}
		header("Location: http://rayyanq.com/plootus/login");

	}
	else{
		header("Location: http://rayyanq.com/plootus");
	}
}
else{
	header("Location: http://rayyanq.com/plootus");
}
