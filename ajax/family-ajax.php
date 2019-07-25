<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/MemberAjaxAction.php");

	$action = new MemberAjaxAction();
	$action->execute();

	echo(json_encode($action->results));