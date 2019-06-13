<?php
	require_once("action/CorsAjaxAction.php");

	$action = new CorsAjaxAction();
	$action->execute();

	echo json_encode($action->result);