<?php
	require_once("action/PostsAjaxAction.php");

	$action = new PostsAjaxAction();
	$action->execute();

	echo json_encode($action->results);