<?php require_once("functions/functionsIndex.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Kikiclub</title>

	<!-- SCRIPT -->

		<!-- CUSTOM -->
		<script src="scripts/main.js"></script>

		<!-- JQUERY -->
		<script src="scripts/jquery.js"></script>
		<script src="scripts/jquery-ui.js"></script>

		<!-- CKEDITOR -->
		<script src="scripts/ckeditor.js"></script>

		<!-- DROPZONE -->
		<script src="scripts/dropzone.js"></script>

		<!-- BOOTSTRAP -->
		<script src="scripts/bootstrap/bootstrap.bundle.min.js"></script>

		<!-- GOOGLE -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>

	<!-- PAGE CUSTOM -->
		<link rel="stylesheet" href="./css/show-users.css" type="text/css" media="screen" />
		<script src="./scripts/show-users.js"></script>

	<!-- CSS -->
		<!-- FONTS -->
		<link rel="stylesheet" href="css/fonts.css">
		<!-- CUSTOM -->
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

		<?php
				if(!empty($action->page_name))
				{
					?>

						<link rel="stylesheet" href="css/<?= $action->page_name ?>.css">
						<script src="./scripts/<?= $action->page_name ?>.js"></script>
					<?php
				}

		?>
		<!-- JQUERY -->
		<link rel="stylesheet" href="css/jquery-ui.css">

		<!-- DROPZONE -->
		<link rel="stylesheet" href="css/dropzone.css">

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
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.3"></script>

<div id="box"></div>

<script>let langData = <?= json_encode($action->trans->langData) ?></script>
<?php
	if($action->isLoggedIn())
	{
?>
<header>
	<h1><span class="colored-kikicode">Kiki</span>club</h1>
</header>
<?php
	}
	?>

<nav id="menu" class="navbar navbar-inverse navbar-static-top" >

	<div class="container">
    <div class="navbar-header">
			<a href="#" class="btn btn-info btn-sm navbar-toggle collapsed colored-kikicode hover" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span	> Menu</span>
				<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<i class="arrow down"></i>
			</a>
		</div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		 <?php
			if($action->isLoggedIn())
			{
				if($action->page_name != 'users' && $action->page_name != 'console' )
				{
					?>
						<li><a class="nav-item nav-link" id="setting-button" onclick="showProfiles()"></a></li>
					<?php
				}
				?>
					<li><a class="nav-item nav-link" href="users.php"><?= $action->trans->read("main","home") ?></a></li>
				<?php
				if($action->isAdmin()){
				?>
					<li  class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $action->trans->read("main","admin") ?></a>
						<ul class="dropdown-menu">
							<form action="console.php" method="post">
								<li> <button class="btn-link" name="users"><?= $action->trans->read("main","users") ?></button></li>
								<li> <button class="btn-link" name="workshops"><?= $action->trans->read("main","workshops") ?></button></li>
								<li> <button class="btn-link" name="robots"><?= $action->trans->read("main","robots") ?></button></li>
							</form>
						</ul>
					</li>
				<?php
				}
				?>
				<li><a class="nav-item nav-link" onclick="signOut()"><?= $action->trans->read("main","signout") ?></a></li>
				<?php
			}
			else
			{
				?>
				<li><a class="nav-item nav-link" href="login.php"><?= $action->trans->read("main","signin") ?></a></li>
				<?php
			}
			?>
			<li><a class="nav-item nav-link" href="workshops.php"><?= $action->trans->read("main","workshops") ?></a></li>
			<li><a class="nav-item nav-link" href="shared.php">Users Posts</a></li>
    </ul>
  </div>
</div>

	<div class="member-name">
		<?php
			if($action->isFamilyMember())
			{
				?>
					<h3> <?= $action->trans->read("main","welcome") ." " . $action->member_name ?></h3>
				<?php
			}
		?>
	</div>
	<div class="lang"><a href='?lang=fr'>fr</a>/<a href='?lang=en'>en</a></div>

</nav>
<span id="siteseal"><script async type="text/./javascript" src="https://seal.godaddy.com/getSeal?sealID=DfItWm2Knz3813g59XlANqmd3IENFd158H6y2EYMnNEGIsbPfKWd6OGWpwn7"></script></span>
