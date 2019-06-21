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
								<?php
									foreach ($action->difficulty as $diff) {
										?>
											<li onclick="setSearchParams('difficulty',<?=$diff['ID'] ?>,this)"><?= $diff["NAME"] ?></li>
										<?php
									}
								?>
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
								<li onclick="setSearchParams('age',1,this)">1st Grade</li>
								<li onclick="setSearchParams('age',2,this)">2nd Grade</li>
								<li onclick="setSearchParams('age',3,this)">3rd Grade</li>
								<li onclick="setSearchParams('age',4,this)">4th Grage</li>
								<li onclick="setSearchParams('age',5,this)">5th Grage</li>
								<li onclick="setSearchParams('age',6,this)">6th Grage</li>
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
								<li onclick="setSearchParams('state',2,this)">Completed</li>
								<li onclick="setSearchParams('state',1,this)">In Progress</li>
								<li onclick="setSearchParams('state',0,this)">Not Started</li>
								<li onclick="setSearchParams('state',-1,this)">New</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingRobot">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseRobots" aria-expanded="true" aria-controls="collapseRobots">
							Robots
							</button>
						</h5>
						</div>

						<div id="collapseRobots" class="collapse show" aria-labelledby="headingRobot" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<?php
									foreach ($action->robots as $robot) {
										?>
											<li onclick="setSearchParams('robot',<?=$robot['ID'] ?>,this)"><?= $robot["NAME"] ?></li>
										<?php
									}
								?>
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
			<div id='workshops-list'>
				<?php
					loadWorkshopsLine($action->workshops_list,'workshops',$action,"Workshops");
				?>
			</div>


			<?php
		}
		?>

<?php
	require_once("partial/footer.php");