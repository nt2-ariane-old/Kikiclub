<?php
	require_once("action/SendEmailAjaxAction.php");

	$action = new SendEmailAjaxAction();
	$action->execute();

	echo json_encode($action->results);