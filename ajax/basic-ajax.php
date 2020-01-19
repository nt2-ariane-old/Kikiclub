<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/BasicAjaxAction.php");

	$action = new BasicAjaxAction();
	$action->execute();

	echo json_encode($action->results);