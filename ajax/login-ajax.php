<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/LoginAjaxAction.php");
	header('Access-Control-Allow-Origin: http://kikicode.ca');

	$action = new LoginAjaxAction();
	$action->execute();

	echo json_encode($action->results);