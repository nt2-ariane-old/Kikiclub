<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/WorkshopsAction.php");

	$action = new WorkshopsAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="sort">
		<select id="sort_select" onchange="sortAndSearchWorkshops()">
			<option value="none" selected>Sort by</option>
			<option value="recents">Most Recents</option>
			<option value="ascName">Name A-Z</option>
			<option value="descName">Name Z-A</option>
		</select>
	</div>
	<input type="hidden" id="isMember" value="<?= $action->isMember() ?>" >
	<aside>
		<div id="workshop-menu">
			<div id="search-form">
				<div class="card">
					<div class="card-header" id="headingDifficulty">
						<h5 class="mb-0">
							<button class="btn btn-link" aria-expanded="true" aria-controls="collapseDifficulty">
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
													<div><label><input type="checkbox" onclick="setSearchParams('difficulties',<?=$diff['id'] ?>)"><li><?= $diff["name"] ?></li></label></div>
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
									<button class="btn btn-link" aria-expanded="true" aria-controls="collapseAge">
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
													<div><label><input type="checkbox" onclick="setSearchParams('grades',<?=$grade['id'] ?>)"><li><?= $grade["name"] ?></li></label></div>
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
									<button class="btn btn-link" aria-expanded="true" aria-controls="collapseRobots">
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
													<div><label><input type="checkbox" onclick="setSearchParams('robots',<?=$robot['id'] ?>)"><li><?= $robot["name"] ?></li></label></div>
												<?php
											}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<a onclick="deleteSearchParams()"><?= $action->trans->read("workshops","deleteFilter") ?></a>
				</div>
			</aside>
			<main>

			<div id='workshops-list'>
				<script>deleteSearchParams();</script>

			</div>
			<div id='indexes'>

			</div>
			</main>
			<?php
				if($action->admin_mode)
				{
					?>
						<a href='workshop-infos.php?workshop_id='>+</a>
					<?php
				}
			?>
			<?php
				if(!empty($action->stateSearch))
				{
					?>
			<script >setSearchParams('states',<?=$action->stateSearch?>)</script>

					<?php
				}
			?>

			<?php
				if($action->admin_mode)
				{
					?>
						<div class="control-bar">
							<a data-toggle="collapse" data-target="#controls">Control</a>

							<div class="collapse" id="controls">
								<button onclick="change_page('workshop-infos.php',{'workshop_id':null})">Add</button>
								<button onclick="deployed_selected()">Deployed</button>
								<button  onclick="openConfirmBox(null,{type:'function','function':deleteSelected});">Delete</button>
							</div>
						</div>
					<?php
				}
			?>

<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");