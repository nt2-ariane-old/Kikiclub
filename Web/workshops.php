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

			<div id="new">
				<h3>New</h3>
				<div class="workshops-list">
					<?php
						loadWorkshops($action->new);
					?>
				</div>
			</div>
			<div id="completed">
				<h3>Completed</h3>
				<div class="workshops-list">
					<?php
						loadWorkshops($action->completed);
					?>
				</div>
			</div>
			<div id="in-progress">
				<h3>In Progress</h3>
				<div class="workshops-list">
					<?php
						loadWorkshops($action->inProgress);
					?>
				</div>
			</div>
			<div id="not-started">
				<h3>Not Started</h3>
				<div class="workshops-list">
					<?php
						loadWorkshops($action->notStarted);
					?>
				</div>
			</div>


			<a id="manage-btn" href="users.php">Return to Profiles</a>
			<?php
		}
		?>

<?php
	require_once("partial/footer.php");