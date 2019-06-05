<?php
	require_once("action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();

	require_once("partial/header.php");
?>

	<div class="logo"></div>

	<div class="logo-nom"></div>
	<div class="login-block">
	<form action="login.php" method="post" onsubmit="return(logIn());">
		<input type="email" name="email" id="email" placeholder="Email">
		<input type="password" name="psswd" id="password" placeholder="Password">
		<button type="submit">Login</button>
	</form>
	<?php
		//header('Location: '."https://kikinumerique.wixsite.com/kikiclubsandbox/account/kikiclub");
	?>
	</div>
<?php
	require_once("partial/footer.php");