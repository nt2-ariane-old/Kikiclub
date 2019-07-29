<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/RobotInfosAction.php");

	$action = new RobotInfosAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

	<div class='sheet'>
		<?php

			if($action->admin_mode)
			{
				loadRobotEditor($action->robot,$action);
			}
			else
			{
				if($action->exist)
				{
					?>
						<h3><?= $action->robot["name"] ?></h3>
						<h4>Recommanded Grade : <?= $action->grades[$action->robot["id_grade"]]["name"]?></h4>
						<div class="description" ><p><?= $action->robot["description"] ?></p></div>
						<div class="media"><img class="img-rounded" src=<?=$action->robot["media_path"]?> alt=""></div>
					<?php
				}
				else
				{
					?>
					<div class="error-droid">

						<h2>This isn't the robot you're looking for...</h2>
						<img src="images/error/notRobot.gif" alt="">
					</div>
						<?php
				}
			}
			?>
			<div class="robots-footer">
				<a href="robots.php" class="manage-btn">Back</a>
			</div>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");