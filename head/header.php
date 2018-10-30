<?php
include("connect.php");
session_start();
if(isset($_SESSION['UID'])){
	$uid = $_SESSION["UID"];
	$userInfo = mysqli_query($conStudent, "SELECT FirstName,ProfilePic,Class,Level,XP,House,Rewards FROM Students WHERE UID='$uid'");
	$row = mysqli_fetch_assoc($userInfo);
	$firstName = $row["FirstName"];
	$profilePic = $row["ProfilePic"];
	$class = $row["Class"];
	$level = $row["Level"];
	$xp = $row["XP"];
	$house = $row["House"];
	$rewards = $row["Rewards"];
} else {
	echo"<meta http-equiv=\"refresh\" content=\"0; url=http://rayyanq.com/plootus/login\">";
}
?>
<link rel="stylesheet" type="text/css" href="css/students.css">
<header>
	<h1 id="logo">Plootus</h1>
	<div id="header-right">
		<div id="search">
			<input type="text" placeholder="Search">
		</div>
		<div id="header-right-item">
			<img src="img/notification.png" class="header-item">
			<img src="<?php echo $profilePic;?>" class="header-item">
		</div>
	</div>
</header>