<?php
	require_once("action/FamilyWorkshopsAjaxAction.php");

	$action = new FamilyWorkshopsAjaxAction();
	$action->execute();

	echo(json_encode($action->results));