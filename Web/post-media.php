<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/PostMediaAction.php");

	$action = new PostMediaAction();
	$action->execute();

	echo json_encode($action->results);