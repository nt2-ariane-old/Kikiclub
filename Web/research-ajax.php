<?php
	require_once("action/ResearchAjaxAction.php");

	$action = new ResearchAjaxAction();
	$action->execute();

	echo json_encode($action->results);