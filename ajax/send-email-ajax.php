<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/SendEmailAjaxAction.php");

	$action = new SendEmailAjaxAction();
	$action->execute();

	echo json_encode($action->results);