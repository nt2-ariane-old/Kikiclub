<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/FamilyWorkshopsAjaxAction.php");

	$action = new FamilyWorkshopsAjaxAction();
	$action->execute();

	echo(json_encode($action->results));