<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/WorkshopsAjaxAction.php");

	$action = new WorkshopsAjaxAction();
	$action->execute();

	echo json_encode($action->results);