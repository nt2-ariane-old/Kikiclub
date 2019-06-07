<?php
	require_once("action/CorsAjaxAction.php");

	$action = new CorsAjaxAction();
	$action->execute();

	echo $action->result;