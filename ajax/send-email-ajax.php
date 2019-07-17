<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/SendEmailAjaxAction.php");

	$action = new SendEmailAjaxAction();
	$action->execute();

	echo json_encode($action->results);