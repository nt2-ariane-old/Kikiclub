<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="sheet">
		<h2>Generate Random</h2>
		<form action="console.php" method="post">
			<input type="number" name="value" id="value">
			<button type="submit" name="workshop">add workshops</button>
			<button type="submit" name="user">add users</button>
			<button type="submit" name="robot">add robots</button>
			<button type="submit" name="member">add members</button>

		</form>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");