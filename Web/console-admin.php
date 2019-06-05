<?php
	require_once("action/ConsoleAdminAction.php");

	$action = new ConsoleAdminAction();
	$action->execute();

	require_once("partial/header.php");
?>

<nav>
	<ul>
		<li><a href="?page=workshops">Workshops</a></li>
		<li><a href="?page=users">Users</a></li>
	</ul>
</nav>
<?php
	require_once("partial/footer.php");