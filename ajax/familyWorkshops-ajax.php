<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/FamilyWorkshopsAjaxAction.php");

	$action = new FamilyWorkshopsAjaxAction();
	$action->execute();

	echo(json_encode($action->results));