<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/MaterialAjaxAction.php");

	$action = new MaterialAjaxAction();
	$action->execute();

	echo json_encode($action->results);