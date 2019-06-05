<?php
	require_once("action/LoginAjaxAction.php");
	header('Access-Control-Allow-Origin: https://kikinumerique.wixsite.com/kikiclubsandbox');

	$action = new LoginAjaxAction();
	$action->execute();

	echo json_encode($action->results);