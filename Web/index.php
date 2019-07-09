<?php
	require_once("action/IndexAction.php");

	$action = new IndexAction();
	$action->execute();

	require_once("partial/header.php");

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
			?>
				<!-- <script>window.location = "https://kikinumerique.wixsite.com/kikiclubsandbox/blank-5";</script> -->
				<script>window.location = "login.php";</script>
			<?php
		}
	?>
<?php
	require_once("partial/footer.php");