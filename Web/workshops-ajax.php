<?php
	require_once("action/WorkshopsAjaxAction.php");

	$action = new WorkshopsAjaxAction();
	$action->execute();

	echo json_encode($action->results);