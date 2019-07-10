<?php
	require_once("action/SearchAjaxAction.php");

	$action = new SearchAjaxAction();
	$action->execute();

	echo json_encode($action->results);