<?php
	require_once("functions/functionsIndex.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Kikiclub</title>

	<!-- SCRIPT -->
		<!-- CUSTOM -->
		<script src="javascript/main.js"></script>

		<!-- JQUERY -->
		<script src="javascript/jquery.js"></script>
		<script src="javascript/jquery-ui.js"></script>

		<!-- CKEDITOR -->
		<script src="javascript/ckeditor.js"></script>

		<!-- BOOTSTRAP -->
		<script src="javascript/bootstrap/bootstrap.bundle.min.js"></script>

		<!-- GOOGLE -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<!-- FACEBOOK -->
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v3.3&appId=670117443417077&autoLogAppEvents=1"></script>

	<!-- PAGE CUSTOM -->
		<link rel="stylesheet" href="./css/users.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/users-mobile.css" type="text/css" media="handheld" />
		<script src="javascript/users.js"></script>

	<?php
		if($action->page_name == 'workshops')
		{
			?>
				<link rel="stylesheet" href="css/workshops.css">
				<script src="javascript/workshops.js"></script>
			<?php
		}
		if($action->page_name == 'login')
		{
			?>
				<link rel="stylesheet" href="css/login.css">
				<script src="javascript/login.js"></script>
			<?php
		}
		if($action->page_name == 'console')
		{
			?>
				<link rel="stylesheet" href="css/console.css">
				<script src="javascript/admin.js"></script>
			<?php
		}


	?>
	<!-- CSS -->
		<!-- CUSTOM -->
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/main-mobile.css" type="text/css" media="handheld" />

		<!-- JQUERY -->
		<link rel="stylesheet" href="css/jquery-ui.css">

		<!-- BOOTSTRAP -->
		<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

		<!-- STARS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<!-- META -->
		<!-- GOOGLE -->
		<meta name="google-signin-client_id" content="704832246976-9gtrh525ke8s7p8kp9vatgals73l22ud.apps.googleusercontent.com">


	<!-- FAVICON -->
		<link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
		<link rel="manifest" href="images/favicon/manifest.json">

		<meta name="msapplication-TileColor" content="#D8DF23">
		<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#D8DF23">
</head>
<body onload="loadModules(); onPageLoad();">
<div id="fb-root"></div>

<div id="box"></div>
<?php
	if($action->isLoggedIn())
	{
?>
<header>
	<h1><span class="colored-kikicode">Kiki</span>club</h1>
</header>
<nav id="menu" class="navbar navbar-inverse navbar-static-top" >

	<div class="container">
    <div class="navbar-header">
			<a href="#" class="btn btn-info btn-sm navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span	> <?= $action->complete_name ?></span>
				<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		 <?php
			if(!($action->page_name == 'users' ||
			$action->page_name == 'console' ))
			{
				?>
					<li><a class="nav-item nav-link" id="setting-button" onclick="showProfiles()"></a></li>

				<?php
			}
			if($action->page_name != 'users')
			{
				?>
					<li><a class="nav-item nav-link" href="users.php">Home</a></li>
				<?php
			}
			if($action->page_name != 'workshops' && $action->isFamilyMember())
			{
				?>
					<li><a class="nav-item nav-link" href="workshops.php">Workshops</a></li>
				<?php
			}
			if($action->page_name != 'workshops-research' && $action->isFamilyMember())
			{
				?>
					<li><a class="nav-item nav-link" href="workshops-research.php">Workshops Research</a></li>
				<?php
			}

			?>
				<form action="users.php" method="post">
					<li> <button class="btn-link" name="manage">Manage Profile</button></li>
				</form>
			<?php
			if($action->isAdmin()){
					?>
						<li  class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Console</a>
								<ul class="dropdown-menu">
									<form action="console.php" method="post">
										<li> <button class="btn-link" name="users">Users</button></li>
										<li> <button class="btn-link" name="workshops">Workshops</button></li>
									</form>
								</ul>
						</li>

					<?php

			}
			?>
				<li><a class="nav-item nav-link" onclick="signOut()">Sign out</a></li>
			<?php
		?>

      </ul>
    </div>
	</div>
	<?php
		?>
		<div class="member-name">
			<?php
					if($action->isFamilyMember())
					{
						?>
							<h3>Welcome <?= $action->member_name ?></h3>
						<?php
					}
			?>
		</div>
		<?php
	?>
</nav>
<?php
	}
?>