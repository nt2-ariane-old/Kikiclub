<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/BadgesAjaxAction.php");

	$action = new BadgesAjaxAction();
	$action->execute();

	echo json_encode($action->results);