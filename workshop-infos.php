<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/WorkshopInfosAction.php");

	$action = new WorkshopInfosAction();
	$action->execute();

	require_once("partial/header.php");
?>

	<?php
		if(!empty($action->workshop))
		{
			if($action->isLoggedIn())
			{
				?>
					<div class="workshop" id="workshop-infos">
						<script>loadMedia(<?= json_encode($action->workshop) ?>,document.getElementById("workshop-infos") )</script>
						<div class="infos" id="infos">
						<h2><?= $action->workshop["NAME"] ?></h2>
						<script>loadStars(<?= json_encode($action->workshop) ?>,document.getElementById("infos") )</script>


						<p><?=  $action->workshop["CONTENT"]?></p>


						</div>

					</div>
				<?php
			}
			else
			{
				?>

				<?php
			}
		}
		else
		{
			?>
				<div>No Workshop</div>

				<script>window.location = "error.php?404";</script>
			<?php
		}
	?>
<?php
	require_once("partial/footer.php");