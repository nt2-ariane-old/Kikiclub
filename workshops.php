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

	<div class="btn-filter" onclick="openFilters()">
		<span>Filtrer</span>
	</div>
	<aside>
		<span id="x-aside" onclick="closeFilters()">x</span>
		<h2>Filtrer</h2>
		<div id="workshop-menu">
			<div class="search-form" id="difficulty-form">
				<div class="card">
					<div class="card-header" id="headingDifficulty" onclick="plusMinusSign(this)" data-toggle="collapse" data-target="#collapseDifficulty" aria-expanded="false" aria-controls="collapseDifficulty">
						<h5 class="mb-0"><?= $action->trans->read('workshops','difficulty') ?></h5>
						<span class="buttonSign">+</span>
					</div>

					<div id="collapseDifficulty" class="collapse multi-collapse" aria-labelledby="headingDifficulty" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<?php
									foreach ($action->difficulty as $diff) {
										?>
											<div>
												<label>
													<input type="checkbox" onclick="setSearchParams('difficulties',<?=$diff['id'] ?>)">
													<span></span><li><?= $diff["name"] ?></li>
												</label>
											<div>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="search-form" id="age-form">
				<div class="card" >
					<div class="card-header" id="headingAge" onclick="plusMinusSign(this)" data-toggle="collapse" data-target="#collapseAge" aria-expanded="false" aria-controls="collapseAge">
						<h5 class="mb-0"><?= $action->trans->read('workshops','scholar') ?></h5>
						<span class="buttonSign">+</span>
					</div>
					<div id="collapseAge" class="collapse" aria-labelledby="headingAge" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<?php
									foreach ($action->grades as $grade) {
										?>
											<div><label><input type="checkbox" onclick="setSearchParams('grades',<?=$grade['id'] ?>)"><span></span><li><?= $grade["name"] ?></li></label></div>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="search-form" id="robot-form">
				<div class="card">
					<div class="card-header" id="headingRobot" onclick="plusMinusSign(this)" data-toggle="collapse" data-target="#collapseRobots" aria-expanded="false" aria-controls="collapseRobots">
						<h5 class="mb-0"><?= $action->trans->read('workshops','robots') ?></h5>
						<span class="buttonSign">+</span>
					</div>
					<div id="collapseRobots" class="collapse multi-collapse" aria-labelledby="headingRobot" data-parent="#workshop-menu">
						<div class="card-body">
							<ul>
								<?php
									foreach ($action->robots as $robot) {
										?>
											<div><label><input type="checkbox" onclick="setSearchParams('robots',<?=$robot['id'] ?>)"><span></span><li><?= $robot["name"] ?></li></label></div>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a onclick="deleteSearchParams()"><?= $action->trans->read("workshops","deleteFilter") ?></a>
	</aside>
	<main>
		<div id='workshops-list'>
			<script>deleteSearchParams();</script>
		</div>
		<div id='indexes'></div>
	</main>

	<?php
		if($action->admin_mode)
		{
			?>
				<div class="control-bar">
					<a data-toggle="collapse" data-target="#controls">Control</a>
					<div class="collapse" id="controls">
						<button class="submit-btn" onclick="change_page('workshop-infos.php',{'workshop_id':null})">Add</button>
						<button class="submit-btn" onclick="deployed_selected()">Deployed</button>
						<button class="delete-btn" onclick="openConfirmBox(null,{type:'function','function':deleteSelected});">Delete</button>
					</div>
				</div>
			<?php
		}
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");