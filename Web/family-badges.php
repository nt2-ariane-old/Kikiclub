<?php
	require_once("action/FamilyBadgesAction.php");

	$action = new FamilyBadgesAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<main>
		<section>

			<?php
				foreach ($action->badges as $badge) {
					?>
						<div class="badge">
							<?php loadMedia($badge) ?>
							<?= $badge["NAME"] ?>
						</div>
					<?php
				}
			?>
		</section>
	</main>
<?php
	require_once("partial/footer.php");