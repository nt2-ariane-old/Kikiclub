<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/EditTextAjaxAction.php");

	$action = new EditTextAjaxAction();
	$action->execute();