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
		<a href="index.php" class="manage-btn"><?= $action->trans->read("all_pages","back") ?></a>
	</div>

	<?php
				if($action->admin_mode)
				{
					?>
						<div class="control-bar">
							<a data-toggle="collapse" data-target="#controls"><?= $action->trans->read("all_pages","control") ?></a>

							<div class="collapse" id="controls">
								<button class="submit-btn" onclick="addBadge()"><?= $action->trans->read("all_pages","add") ?></button>
								<button class="delete-btn" onclick="openConfirmBox(null,{type:'function','function':deleteBadges});"><?= $action->trans->read("all_pages","delete") ?></button>
							</div>
						</div>
					<?php
				}
			?>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");