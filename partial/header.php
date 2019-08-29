<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/functions/functionsIndex.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Kikiclub</title>


	<!-- CSS -->
		<!-- FONTS -->
		<link rel="stylesheet" href="css/fonts.css">

		<!-- CAROUSEL SLICK-->
		<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
		<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

				<!-- JQUERY -->
		<link rel="stylesheet" href="css/jquery-ui.css">

		<!-- DROPZONE -->
		<link rel="stylesheet" href="css/dropzone.css">

		<!-- BOOTSTRAP -->
		<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

		<!-- STARS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- CUSTOM -->
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/carousel.css" type="text/css" media="screen" />

		<?php
			if(!empty($action->page_name))
			{
				?>
					<link rel="stylesheet" href="css/<?= $action->page_name ?>.css">
				<?php
			}
		?>

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
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

		<meta name="msapplication-TileColor" content="#D8DF23">
		<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#D8DF23">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- SCRIPTS -->


		<!-- JQUERY -->
		<script type="text/javascript" src="scripts/jquery.js"></script>
		<script type="text/javascript" src="scripts/jquery.min.js"></script>
		<script type="text/javascript" src="scripts/jquery-migrate.min.js"></script>
		<script type="text/javascript" src="scripts/jquery-ui.js"></script>

		<!-- CKEDITOR -->
		<script src="scripts/ckeditor.js"></script>

		<!-- DROPZONE -->
		<script src="scripts/dropzone.js"></script>

		<!-- BOOTSTRAP -->
		<script src="scripts/bootstrap/bootstrap.bundle.min.js"></script>
		<!-- WOW.JS -->
		<script src="scripts/wow.js"></script>
		<script src="scripts/wow.min.js"></script>
		<link rel="stylesheet" href="css/animate.css">

		<!-- CAROUSEL -->
		<script src="./scripts/carousel.js"></script>
		<!-- CUSTOM -->
		<script src="scripts/main.js"></script>
		<?php
			if(!empty($action->page_name))
			{
				?>
					<script src="./scripts/<?= $action->page_name ?>.js"></script>
				<?php
			}
			if($action->admin_mode)
			{
				?>
					<link rel="stylesheet" href="css/admin.css">
					<script src="./scripts/admin.js"></script>

			<?php
			}
		?>
</head>
<body onload="loadModules(); onPageLoad();<?php if($action->admin_mode) echo 'adminLoad();'?>">
<div id="box"></div>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v4.0&appId=670117443417077&autoLogAppEvents=1"></script>

<script>
	let langData = <?= json_encode($action->trans->langData) ?>;
</script>

<header>

	<a href="index.php"><h1><span class="colored-kikicode">Kiki</span>club</h1></a>
	<?php
		if($action->page_name == 'robots' ||
		$action->page_name == 'workshops' ||
		$action->page_name == 'shared')
		{
			?>
				<h2><?= $action->trans->read("all_pages","the") ?> <span class="colored-kikicode"><?= $action->complete_name?></span></h2>
			<?php
		}
	?>
	<a href="manage-member.php"><div id="header-infos">
		<?php
			if($action->isMember())
			{
				?>
					<h5> <?= $action->member_name ?></h5>
				<?php
					loadMedia($action->member_avatar);
			}
			if($action->isLoggedIn())
			{

			}
			else
			{
				?>
					<a <?php if($action->url === "localhost") { ?> onclick="window.location = 'login.php?other'"; <?php } else { ?> onclick="window.location = 'https://kikinumerique.wixsite.com/kikiclubsandbox/blank-5' "; <?php }?>>Se Connecter</a>
				<?php
			}
		?>
		
	</div></a>
</header>

<nav id="menu" class="  navbar navbar-inverse navbar-static-top" >
	<div class="container">
    <div class="navbar-header">
			<a href="#" class="btn btn-info btn-sm navbar-toggle collapsed colored-kikicode hover" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span	id="hamburger"></span>
				<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
		</div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<li><a class="nav-item nav-link" href="<?php if($action->isLoggedIn()) { ?>users.php <?php } else { ?>login.php<?php } ?>"><?= $action->trans->read("pages_name","home") ?></a></li>
		<li> <a class="nav-item nav-link" href="workshops.php"><?= $action->trans->read("pages_name","workshops") ?></a>
				<?php
					if($action->isLoggedIn())
					{
						?>

					<ul>
						<?php
							foreach ($action->members as $member) {
								?>
									<li><a onclick="change_page('member-home.php',{'member_id':<?= $member["id"] ?>})"><?= $member["firstname"] ?></a></li>
									<?php
							}
							?>
					</ul>
					<li><a href="reference.php">Reference</a></li>
							<?php
						}
					?>
				</li>
				<li><a class="nav-item nav-link" href="robots.php"><?= $action->trans->read("pages_name","robots") ?></a></li>
				<!-- <li><a class="nav-item nav-link" href="shared.php"><?= $action->trans->read("pages_name","shared") ?></a></li> -->
				<li><a href='?lang=fr'>fr</a>/<a href='?lang=en'>en</a></li>

				<?php
			if($action->isLoggedIn())
			{
				if($action->isAdmin()){
					?>
					<li><a class="nav-item nav-link" href="?admin=<?php if($action->admin_mode) echo 'false'; else echo 'true'; ?>"><?php if($action->admin_mode) { echo $action->trans->read("admin","as-user") ; } else {echo $action->trans->read("admin","as-admin");} ?></a></li>
					<?php
						if($action->admin_mode)
						{
							?>
								<li><?= $action->trans->read("admin","tools") ?>
									<ul>
										<li><a class="nav-item nav-link" href="badges.php"><?= $action->trans->read("pages_name","badges") ?></a></li>
										<li><a class="nav-item nav-link" href="console.php"><?= $action->trans->read("pages_name","console") ?></a></li>
										<li><a class="nav-item nav-link" href="materials.php"><?= $action->trans->read("pages_name","materials") ?></a></li>
									</ul>
								</li>
							<?php
						}
					?>
				<?php
				}
				?>
				<li><a class="nav-item nav-link" href="?logout=true"><?= $action->trans->read("all_pages","signout") ?></a></li>
				<?php
			}
			
			?>

    </ul>
	</div>


</div>
</nav>