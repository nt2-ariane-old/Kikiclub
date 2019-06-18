<?php
	require_once("action/ResetAction.php");

	$action = new ResetAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<h1>Reset password</h1>
	<?php
		if($action->tokenIsOkay())
		{
			?>

			<?php
		}
		else
		{
			?>
				<h3>Entrez votre courriel pour changer votre mot de passe :</h3>

				<form action="reset.php" method="post" onSubmit="return openConfirmBox()">
					<input type="email" name="email">
					<button type="submit">Envoyer</button>
				</form>
			<?php
		}
	?>
<?php
	require_once("partial/footer.php");