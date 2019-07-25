<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/BadgesAction.php");

	$action = new BadgesAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
		<section>
			<?php
				loadBadgesLine($action->badges,'Badges',$action,'Badges');
			?>

		</section>

	</main>

	<div class="badges-footer">
		<a href="index.php" class="manage-btn">Back</a>
	</div>

	<?php
				if($action->admin_mode)
				{
					?>
						<div class="control-bar">
							<a data-toggle="collapse" data-target="#controls">Control</a>

							<div class="collapse" id="controls">
								<button class="submit-btn" onclick="addBadge()">Add</button>
								<button class="delete-btn" onclick="openConfirmBox(null,{type:'function','function':deleteBadges});">Delete</button>
							</div>
						</div>
					<?php
				}
			?>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");