<?php
	require_once("action/FamilyBadgesAction.php");

	$action = new FamilyBadgesAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<main>
		<section>

			<?php
				loadBadgesCarousel($action->badges,'Badges',$action,'Badges')
			?>
			<article id="pts">
				Your Family Cumulated <?= $action->family_pts ?> pts.
				<?php
					if($action->is_member)
					{
						?>
							You Cumulated <?= $action->member_pts ?> pts.
						<?php
					}
				?>
			</article>
		</section>

	</main>
<?php
	require_once("partial/footer.php");