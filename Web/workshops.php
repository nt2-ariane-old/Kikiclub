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

	<input type="hidden" id="isFamilyMember" value="<?= $action->isFamilyMember() ?>" >
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
											<div><label><input type="checkbox" onclick="setSearchParams('difficulties',<?=$diff['ID'] ?>)"><li><?= $diff["NAME"] ?></li></label></div>
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
											<div><label><input type="checkbox" onclick="setSearchParams('grades',<?=$grade['ID'] ?>)"><li><?= $grade["NAME"] ?></li></label></div>
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
											<div><label><input type="checkbox" onclick="setSearchParams('states',<?=$state['ID'] ?>)"><li><?= $state["NAME"] ?></li></label></div>
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
											<div><label><input type="checkbox" onclick="setSearchParams('robots',<?=$robot['ID'] ?>)"><li><?= $robot["NAME"] ?></li></label></div>
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