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

			<div id="workshop-menu">
				<div class="card">
					<div class="card-header" id="headingDifficulty">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseDifficulty" aria-expanded="true" aria-controls="collapseDifficulty">
							Difficulty
							</button>
						</h5>
						</div>

						<div id="collapseDifficulty" class="collapse show" aria-labelledby="headingDifficulty" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<li>Débutant</li>
								<li>Intérmédiaire</li>
								<li>Avancé</li>
								<li>Expert</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header" id="headingAge">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseAge" aria-expanded="true" aria-controls="collapseAge">
							Suggested Scholar Level
							</button>
						</h5>
						</div>

						<div id="collapseAge" class="collapse show" aria-labelledby="headingAge" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<li>1st Grade</li>
								<li>2nd Grade</li>
								<li>3rd Grade</li>
								<li>4th Grage</li>
								<li>5th Grage</li>
								<li>6th Grage</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingState">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseState" aria-expanded="true" aria-controls="collapseState">
							Workshop State
							</button>
						</h5>
						</div>

						<div id="collapseState" class="collapse show" aria-labelledby="headingState" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<li>Completed</li>
								<li>In Progress</li>
								<li>Not Started</li>
								<li>New</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="sort">
				<select onchange="sortWorkshops(this)">
					<option value="none" selected>Sort by</option>
					<option value="recents">Most Recents</option>
					<option value="ascName">Name A-Z</option>
					<option value="descName">Name Z-A</option>
				</select>
			</div>
			<div>
				<?php
					loadWorkshopsLine($action->workshops_list,'workshops',$action,"Workshops");
				?>
			</div>


			<?php
		}
		?>

<?php
	require_once("partial/footer.php");