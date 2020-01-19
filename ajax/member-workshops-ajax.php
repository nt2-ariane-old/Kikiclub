<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/MemberWorkshopsAjaxAction.php");

	$action = new MemberWorkshopsAjaxAction();
	$action->execute();

	echo(json_encode($action->results));