<?php
	require_once("action/UsersAction.php");

	$action = new UsersAction();
	$action->execute();

	require_once("partial/header.php");
	require_once("partial/show-users.php");
	require_once("partial/footer.php");