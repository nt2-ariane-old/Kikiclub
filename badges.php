<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/BadgesAction.php");

	$action = new BadgesAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
		<section>

			<?php
				loadBadgesCarousel($action->badges,'Badges',$action,'Badges')
			?>

		</section>

	</main>
	<div class="badges-footer">
		<a href="index.php" class="manage-btn">Back</a>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");