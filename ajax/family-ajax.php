<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/FamilyAjaxAction.php");

	$action = new FamilyAjaxAction();
	$action->execute();

	echo(json_encode($action->results));