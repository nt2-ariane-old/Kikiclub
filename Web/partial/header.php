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
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		<!-- GOOGLE -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<!-- FACEBOOK -->
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v3.3&appId=670117443417077&autoLogAppEvents=1"></script>

		<!-- DIY SLIDER -->
		<script src="jquery.diyslider.min.js"></script>


	<!-- CSS -->
		<!-- CUSTOM -->
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/main-mobile.css" type="text/css" media="handheld" />

		<!-- JQUERY -->
		<link rel="stylesheet" href="css/jquery-ui.css">

		<!-- BOOTSTRAP -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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



<nav>
	<div id="setting-button" onclick="showProfiles()"></div>
	<ul>

		<?php
			if($action->isLoggedIn())
			{
				?>
					<li><button onclick="signOut()">Sign out</button></li>
				<?php
			}
			if($action->isAdmin()){
				?>
					<li><button onclick="window.location.href='console.php'">Admin Console</button></li>
				<?php
			}
		?>

	</ul>
</nav>