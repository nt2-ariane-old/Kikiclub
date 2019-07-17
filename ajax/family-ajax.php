<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/FamilyAjaxAction.php");

	$action = new FamilyAjaxAction();
	$action->execute();

	echo(json_encode($action->results));