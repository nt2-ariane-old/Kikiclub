<?php
	require_once("action/IndexAction.php");

	$action = new IndexAction();
	$action->execute();

	require_once("partial/header.php");

?>
	<script src="javascript/users.js"></script>


	<?php
		if($action->isLoggedIn())
		{
			?>

			<?php
		}
		else
		{
			if(!$_SESSION["executed"])
			{
				header('Location: '."login.php");
			}
		}
	?>
<?php
	require_once("partial/footer.php");