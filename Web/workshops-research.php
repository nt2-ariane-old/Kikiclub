<?php
	require_once("action/WorkshopsResearchAction.php");

	$action = new WorkshopsResearchAction();
	$action->execute();

	require_once("partial/header.php");
?>

<?php
	require_once("partial/footer.php");