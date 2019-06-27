<?php
	require_once("action/WorkshopsAction.php");

	$action = new WorkshopsAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<div class="sort">
		<select id="sort_select" onchange="sortAndSearchWorkshops()">
			<option value="none" selected>Sort by</option>
			<option value="recents">Most Recents</option>
			<option value="ascName">Name A-Z</option>
			<option value="descName">Name Z-A</option>
		</select>
	</div>

	<div id="workshop-menu">
		<div class="card">
			<div class="card-header" id="headingDifficulty">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseDifficulty" aria-expanded="true" aria-controls="collapseDifficulty">
						<?= $action->trans->read('workshops','difficulty') ?>
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
							<?= $action->trans->read('workshops','scholar') ?>
							</button>
						</h5>
						</div>

						<div id="collapseAge" class="collapse show" aria-labelledby="headingAge" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<?php
									foreach ($action->grades as $grade) {
										?>
											<li onclick="setSearchParams('age',<?=$grade['ID'] ?>,this)"><?= $grade["NAME"] ?></li>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingState">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseState" aria-expanded="true" aria-controls="collapseState">

							<?= $action->trans->read('workshops','state') ?>
							</button>
						</h5>
						</div>

						<div id="collapseState" class="collapse show" aria-labelledby="headingState" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<?php
									foreach ($action->workshopStates as $state) {
										?>
											<li onclick="setSearchParams('state',<?=$state['ID'] ?>,this)"><?= $state["NAME"] ?></li>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingRobot">
						<h5 class="mb-0">
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseRobots" aria-expanded="true" aria-controls="collapseRobots">
							<?= $action->trans->read('workshops','robots') ?>
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
				<a onclick="deleteSearchParams()"><?= $action->trans->read("workshops","deleteFilter") ?></a>
			</div>

			<div id='workshops-list'>
				<script>deleteSearchParams();</script>
			</div>

<?php
	require_once("partial/footer.php");