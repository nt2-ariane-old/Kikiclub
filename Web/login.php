<?php
	require_once("action/LoginAction.php");

	$action = new LoginAction();
	$action->execute();

	require_once("partial/header.php");
?>
<form name="login" action="login.php" onsubmit="return validateForm()" method="post">
	<input type="email" name="email" id="email">
	<input type="password" name="password" id="password">
	<button type="submit">Se Connecter</button>

</form>
<?php
	require_once("partial/footer.php");