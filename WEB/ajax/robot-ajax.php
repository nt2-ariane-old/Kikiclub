<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/RobotAjaxAction.php");

	$action = new RobotAjaxAction();
	$action->execute();

	echo json_encode($action->results);