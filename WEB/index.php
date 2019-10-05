<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

	<div class="login-block">

	<?php

		if($action->error)
		{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
		}
 		if ($action->signup && $action->url === "localhost")
		{
			?>
			<section>

				<!-- <form action="index.php?signup=true" method="post" onsubmit="signup()"> -->
				<form action="index.php?signup=true" method="post">
					<input type="hidden" name="type" value="signup">
					<input type="hidden" name="form">
					<input type="text" name="firstname" id="firstname" placeholder="<?=  $action->trans->read("login", "firstname") ?>">
					<input type="text" name="lastname" id="lastname" placeholder="<?=  $action->trans->read("login", "lastname") ?>">
					<input type="email" name="email" id="email" placeholder="<?=  $action->trans->read("login", "email") ?>">
					<input type="password" name="psswd1" id="password1" placeholder="<?=  $action->trans->read("login", "password") ?>">
					<input type="password" name="psswd2" id="password2" placeholder="<?=  $action->trans->read("login", "confirm-password") ?>">
					<button type="submit"><?=  $action->trans->read("login", "signUp") ?></button>
				</form>
				<div class="separator"><?=  $action->trans->read("login", "separator") ?></div>
				<div class="signinButton other"><a href="?other=true"><?=  $action->trans->read("login", "login") ?></a></div>
			</section>
			<?php
		}
		else if($action->otherlogin && $action->url === "localhost")
		{
			?>
			<section>
				<!-- <form action="index.php?other=true" method="post" onsubmit="return(login());"> -->
				<form action="index.php?other=true" method="post">
					<input type="hidden" name="type" value="signin">
					<input type="hidden" name="form">
					<input type="email" name="email" id="email" placeholder="<?= $action->trans->read("login", "email") ?>">
					<input type="password" name="psswd" id="password" placeholder="<?= $action->trans->read("login", "password") ?>">
					<button type="submit"><?=  $action->trans->read("login", "login") ?></button>
				</form>
				<div class="separator"><?=  $action->trans->read("login", "separator") ?></div>
				<div class="signinButton other"><a href="?signup=true"><?=  $action->trans->read("login", "signUp") ?></a></div>
			</section>
			<?php
		}
		else
		{
			?>
				<video autoplay muted loop id="story_bg">
					<source src="https://kikicode.club/videos/home_bg.mov" type="video/mp4">
				</video>
				<div class="story">

					<div class="story_content">
						<h2><?=  $action->trans->read("login", "title") ?></h2>
						<h3><?=  $action->trans->read("login", "subtitle") ?></h3>
						<a href="workshops.php" id="guest-btn" class="big-btn"><?=  $action->trans->read("login", "guest") ?></a>
					</div>

				</div>
		 	<?php
		}




		?>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");