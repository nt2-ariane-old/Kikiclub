<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/IndexAction.php");

	$action = new IndexAction();
	$action->execute();
?>
	<script src="./javascript/users.js"></script>


	<?php
		if($action->isLoggedIn())
		{
			?>
				<script>window.location = "users.php";</script>
			<?php
		}
		else
		{
			if($action->url === "localhost")
			{
				 ?>
			 		<script>window.location = "login.php";</script>
			 	<?php
			}
			else
			{
				?>
					<script>window.location = "workshops.php";</script>
			 	<?php
			}
		}
	?>