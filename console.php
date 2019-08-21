<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="sheet">
		<h2><?= $action->trans->read("console","random") ?></h2>
		<form action="console.php" method="post">
			<input type="number" name="value" id="value">
			<button type="submit" name="workshop"><?= $action->trans->read("console","add-workshops") ?></button>
			<button type="submit" name="user"><?= $action->trans->read("console","add-users") ?></button>
			<button type="submit" name="robot"><?= $action->trans->read("console","add-robots") ?></button>
			<button type="submit" name="member"><?= $action->trans->read("console","add-members") ?></button>

		</form>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");