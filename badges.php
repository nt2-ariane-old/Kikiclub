<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/BadgesAction.php");

	$action = new BadgesAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
		<section>


			<?php
				if($action->admin_mode)
				{
					loadBadgesLine($action->badges,'Badges',$action,'Badges');
				}
				else
				{
					loadBadgesCarousel($action->badges,'Badges',$action,'Badges');
				}
			?>

		</section>

	</main>
	<?php
		if($action->admin_mode)
		{
			?>
				<input type="hidden" id="isAdmin">
				<div class="admin">
					<button class="btn-admin add" onclick="addBadge()"></button>
				</div>
			<?php
		}
	?>
	<div class="badges-footer">
		<a href="index.php" class="manage-btn">Back</a>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");