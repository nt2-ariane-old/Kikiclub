<?php
	require_once("action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();

	require_once("partial/header.php");
?>

	<div class="logo"></div>

	<div class="logo-nom"></div>
	<div class="login-block">

	<?php
		if($action->error)
		{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
		}
		if($action->otherlogin)
		{
			?>
				<!-- <form action="login.php?other=true" method="post" onsubmit="return(login());"> -->
				<form action="login.php?other=true" method="post">
					<input type="hidden" name="type" value="signin">
					<input type="hidden" name="form">
					<input type="email" name="email" id="email" placeholder="<?= $action->trans->read("loginpage", "emailInput") ?>">
					<input type="password" name="psswd" id="password" placeholder="<?= $action->trans->read("loginpage", "passwordInput") ?>">
					<button type="submit"><?=  $action->trans->read("loginpage", "login") ?></button>
				</form>
				<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
				<div class="signinButton other"><a href="?other=false"><?=  $action->trans->read("loginpage", "signIn-Fb") ?></a></div>
				<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
				<div class="signinButton other"><a href="?signup=true"><?=  $action->trans->read("loginpage", "signUp") ?></a></div>
			<?php
		}
		else if ($action->signup)
		{
			?>
			<!-- <form action="login.php?signup=true" method="post" onsubmit="signup()"> -->
			<form action="login.php?signup=true" method="post">
				<input type="hidden" name="type" value="signup">
				<input type="hidden" name="form">

				<input type="text" name="firstname" id="firstname" placeholder="<?=  $action->trans->read("main", "firstnameInput") ?>">
				<input type="text" name="lastname" id="lastname" placeholder="<?=  $action->trans->read("main", "lastnameInput") ?>">
				<input type="email" name="email" id="email" placeholder="<?=  $action->trans->read("loginpage", "emailInput") ?>">
				<input type="password" name="psswd1" id="password1" placeholder="<?=  $action->trans->read("loginpage", "passwordInput") ?>">
				<input type="password" name="psswd2" id="password2" placeholder="<?=  $action->trans->read("loginpage", "confirmPasswordInput") ?>">
				<button type="submit"><?=  $action->trans->read("loginpage", "login") ?></button>
			</form>
			<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
			<div class="signinButton other"><a href="?other=false"><?=  $action->trans->read("loginpage", "signIn-Fb") ?></a></div>
			<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
			<div class="signinButton other"><a href="?other=true"><?=  $action->trans->read("loginpage", "signIn-E") ?></a></div>
		<?php
		}
		else
		{
			?>
				<div class="signinButton"><div id="spinner"><p><?=  $action->trans->read("loginpage", "loading") ?></p><div class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-auto-logout-link="false" data-use-continue-as="false"></div></div></div>
				<div class="signinButton"><div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true" data-width="290px"></div></div>
				<div class="signinButton" id="wix"><a href="https://kikinumerique.wixsite.com/kikiclubsandbox/blank-5"> Se connecter avec Wix </a></div>
				<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
				<div class="signinButton other"><a href="?other=true"><?=  $action->trans->read("loginpage", "signIn-E") ?></a></div>
				<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
				<div class="signinButton other"><a href="?signup=true"><?=  $action->trans->read("loginpage", "signUp") ?></a></div>
			<?php
		}


	?>
	</div>
<?php
	require_once("partial/footer.php");