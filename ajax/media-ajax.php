<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/MediaAjaxAction.php");

	$action = new MediaAjaxAction();
	$action->execute();

	echo json_encode($action->results);