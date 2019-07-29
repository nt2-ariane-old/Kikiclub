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

				loadWorkshopsCreator($action->workshop,$action);

			}
			else
			{
				if(!empty($action->workshop))
				{
					?>
					<div class="sheet">
						<div class="workshop" id="workshop-infos">
							<div class="logo-kiki-café"></div>
							<h2><?= $action->workshop["name"] ?></h2>

							<div class="infos" id="infos">
								<?php

									if(!empty($action->workshop_robots))
									{
										?>
											<p><strong>Type : </strong>
											<?php
												$i = 0;
												foreach ($action->workshop_robots as $robot) {
													if(!empty($robot))
													{
														if($i > 0)
														{
															echo ',';
														}
														?>
															<span><?= $robot["name"] ?></span>
														<?php
														$i++;
													}
												}
												?></p>
										<?php
									}

									if(!empty($action->workshop_grades))
									{
										?>
											<p><strong>Recommanded Grades : </strong>
											<?php
												$i = 0;
												foreach ($action->workshop_grades as $grade) {
													if($i > 0)
													{
														echo ',';
													}
													?>
														<span><?= $grade["name"] ?></span>
													<?php
													$i++;
												}
												?></p>
										<?php
									}
									?>
								<?php
									loadStars($action->workshop_difficulties,$action);
									?>
								<p><strong>Introduction : </strong><?=  $action->workshop["content"]?></p>
							</div>
							<script>loadMedia(<?= json_encode($action->workshop) ?>,document.getElementById("workshop-infos") )</script>
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
			<?php
				if($action->admin_mode)
				{
			?>
				<button class="return-btn" onclick="assignAllUsers()"> Assign All Users</button>
			<?php
				}
			?>
			<a href="workshops.php" class="return-btn">Back</a>
		</div>

		<div id="loading-page"></div>

		<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");