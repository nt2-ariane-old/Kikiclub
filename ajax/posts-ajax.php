<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/PostsAjaxAction.php");

	$action = new PostsAjaxAction();
	$action->execute();

	echo json_encode($action->results);