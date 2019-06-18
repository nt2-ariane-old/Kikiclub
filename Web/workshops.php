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

			<div>
				<?php

					if(sizeof($action->new) > 0)
						loadWorkshopsCarousel($action->new,'new-workshops',$action,"New");

					loadWorkshopsCarousel($action->recommandations,'new-recommandations',$action,"Recommandated");

					if(sizeof($action->completed) > 0)
						loadWorkshopsCarousel($action->completed,'completed-workshops',$action,"Completed");

					if(sizeof($action->inProgress) > 0)
						loadWorkshopsCarousel($action->inProgress,'in-progress-workshops',$action,"In Progress");

					if(sizeof($action->notStarted) > 0)
						loadWorkshopsCarousel($action->notStarted,'not-started-workshops',$action,"Not Started");
				?>
			</div>


			<?php
		}
		?>

<?php
	require_once("partial/footer.php");