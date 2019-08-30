<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/RobotInfosAction.php");

	$action = new RobotInfosAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

	<div class='sheet'>
		<?php
			loadRobotEditor($action->robot,$action);
		?>
		<div class="robots-footer">
			<a href="robots.php" class="manage-btn"><?= $action->trans->read("all_pages","back") ?></a>
		</div>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");