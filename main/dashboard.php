<link rel="stylesheet" type="text/css" href="css/dashboard.css">
<div class="card">
	<div class="horizontal">
		<img src="<?php echo $profilePic;?>" id="profile-img">
		<div id="profile-txt">
			<h1><?php echo $firstName;?></h1>
			<span>Grade <?php echo $class;?></span>
			<span>Level <?php echo $level;?></span>
			<span>
				<div id="progressBar">
					<div id="progress">
						<div id="progress-status" style="width: <?php echo$xp;?>;"><?php echo $xp;?></div>
					</div>
				</div>
			</span>	
		</div>
	</div>
</div>
<div class="card">
	<img src="img/performance.png" height="200" width="200">
</div>

<div class="section-head">My Apps</div>

<div class="card">
	<div class="vertical">	
		<img src="img/performance.png" height="200" width="200">
	</div>
</div>