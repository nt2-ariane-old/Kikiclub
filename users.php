<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/UsersAction.php");

	$action = new UsersAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	require_once("show-users.php");

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");