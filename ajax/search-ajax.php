<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/SearchAjaxAction.php");

	$action = new SearchAjaxAction();
	$action->execute();

	echo json_encode($action->results);