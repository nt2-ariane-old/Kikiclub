<?php
	require_once("action/WorkshopsAction.php");

	$action = new WorkshopsAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<link rel="stylesheet" href="css/workshops.css">
	<script src="javascript/workshops.js"></script>
		<?php
		if($action->show_workshop)
		{
			?>
			<div class="workshop-section">
			<?php
				loadMedia($action->workshop)
			?>
				<h2><?=  $action->workshop["NAME"]?></h2>

					<?php
						loadStars($action->workshop);
					?>
				<p><?=  $action->workshop["CONTENT"]?></p>
				<form action="workshops" method="post"></form>
				<?php
					foreach ($action->questions as $question) {
					?>
						<div class="question">
							<p><?= $question["QUESTION"] ?></p>
							<input type="text" name="<?=$question["ID"]?>">
						</div>
					<?php
					}
				?>
			</div>

			<a id="manage-btn" href="workshops.php">Return to Workshops</a>
			<?php
		}
		else
		{
			?>
			<div class="workshops-list">
			<?php
			foreach($action->workshops_list as $workshop)
			{
				?>

					<a href="?workshop=<?= $workshop["ID"] ?>"><div class="workshop">
						<?php
							loadMedia($workshop);
						?>
						<h2><?=$workshop["NAME"]?></h2>
						<div class="description"><p><?=$workshop["CONTENT"]?></p></div>

						<?php
							loadStars($workshop);
						?>

					</div></a>
				<?php
			}
			?>
			</div>
			<a id="manage-btn" href="users.php">Return to Profiles</a>
			<?php
		}
		?>

<?php
	require_once("partial/footer.php");