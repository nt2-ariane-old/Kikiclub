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
		if ($action->signup)
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
				<button type="submit"><?=  $action->trans->read("loginpage", "signUp") ?></button>
			</form>
			<div class="separator"><?=  $action->trans->read("loginpage", "separator") ?></div>
			<div class="signinButton other"><a href="?other=true"><?=  $action->trans->read("loginpage", "signIn-E") ?></a></div>
		<?php
		}
		else
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
				<div class="signinButton other"><a href="?signup=true"><?=  $action->trans->read("loginpage", "signUp") ?></a></div>
			<?php
		}



		?>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");