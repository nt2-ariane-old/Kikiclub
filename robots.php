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
	<div class="robots-footer">
		<a href="index.php" class="manage-btn">Back</a>
	</div>
	<?php
		if($action->admin_mode)
		{
			?>
				<div class="control-bar">
					<a data-toggle="collapse" data-target="#controls">Control</a>
					<div class="collapse" id="controls">
						<button class="submit-btn" onclick="change_page('robot-infos.php',{'robot_id':null})">Add New Robot</button>
						<!-- <button type="submit" class="delete-btn" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement.parentElement,{type:'form'})">Delete</button> -->
					</div>
				</div>
			<?php
		}
	?>

<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");