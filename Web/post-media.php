<?php
	require_once("action/PostMediaAction.php");

	$action = new PostMediaAction();
	$action->execute();

	echo json_encode($action->results);