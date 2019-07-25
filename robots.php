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
					<?php
						?>
					<div class="robot">
					<a href="robot-infos.php?robot_id=<?= $robot["id"]  ?>" ><div class="media"><img class="img-rounded" src=<?=$robot["media_path"]?> alt=""></div></a>
						<h3><?= $robot["name"] ?></h3>
					</div>
				<?php
			}
		?>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");