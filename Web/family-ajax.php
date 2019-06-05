<?php
	require_once("action/FamilyAjaxAction.php");

	$action = new FamilyAjaxAction();
	$action->execute();

	echo(json_encode($action->results));