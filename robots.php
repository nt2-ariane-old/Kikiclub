<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/RobotsAction.php");

	$action = new RobotsAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
		<div id="mixedSlider" class="multislider">
			<div class="MS-content">
				<?php
					foreach ($action->robots as $robot) {
						?>
					<div class="item">
						<div class="robot" onclick="<?php if($action->admin_mode) { ?> window.location.href = 'robot-infos.php?robot_id=<?= $robot['id'];  ?>' <?php } else { ?>openModal();loadRobot(<?= $robot['id']?>);<?php }?>">
							<div class="media"><img class="img-rounded" src=<?=$robot["media_path"]?> alt=""></div>

						</div>
					</div>
				<?php
					}
					?>
			</div>
			<div class="MS-controls">
				<button id="btn-left" class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
				<button id="btn-right" class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
			</div>
		</div>

	</main>
		<!-- <div class="robots-footer">
			<a href="index.php" class="manage-btn">Back</a>
		</div> -->
		<div id="robot_modal" class="modal">
	  		<span class="close cursor" onclick="closeModal()">&times;</span>
	  		<div id="modal_content" class="modal_content"></div>
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