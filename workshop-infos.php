<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/WorkshopInfosAction.php");

	$action = new WorkshopInfosAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");


			if($action->admin_mode)
			{
				if($action->added)
				{
					?>
						<div style="background-color:green;color:white;">
							Workshop Added!
						</div>
					<?php
				}
				?>

				<aside>
					<div id="workshop-menu">
						<div id="search-form">
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
												foreach ($action->difficulties as $diff) {
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
						</div>
						<a onclick="deleteSearchParams()"><?= $action->trans->read("workshops","deleteFilter") ?></a>
					</div>
				</aside>
				<main>

						<?php
							loadWorkshopsCreator($action->workshop,$action);
						?>

				</main>

				<?php
			}
			else
			{
				if(!empty($action->workshop))
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
						<h3>This Workshop doesn't exist...</h3>
					<?php
				}
		}

		?>
		<div id="btns-zone">
			<a href="workshops.php" class="return-btn">Back</a>
		</div>
		<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");