<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Ajax/BasicAjaxAction.php");

	$action = new BasicAjaxAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");