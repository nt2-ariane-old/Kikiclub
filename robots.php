<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/RobotsAction.php");

	$action = new RobotsAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="sheet">
		<?php
			foreach ($action->robots as $robot) {
				?>
					<a href="robot-infos.php?robot_id=<?= $robot["ID"]  ?>" ><div class="robot">
						<h3><?= $robot["NAME"] ?></h3>
					</div></a>
				<?php
			}
		?>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");