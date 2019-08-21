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

				$workshopExist = false;
				if($action->workshop != null)
				{
					$workshopExist = true;
				}
				?>
					<form action="workshop-infos.php"  method="post" enctype="multipart/form-data">
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
																<div><label><input type="checkbox" name="difficulties[]" value="<?=$diff['id'] ?>" <?php if(!empty($action->filters[$action->id_types['difficulties']])) if(!empty($action->filters[$action->id_types['difficulties']][$diff['id']])) echo 'checked' ?>><li><?= $diff["name"] ?></li></label></div>
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
																<div><label><input type="checkbox" name="grades[]" value="<?=$grade['id'] ?>" <?php if(!empty($action->filters[$action->id_types['grades']])) if(!empty($action->filters[$action->id_types['grades']][$grade['id']])) echo 'checked' ?>><li><?= $grade["name"] ?></li></label></div>
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
																<div><label><input type="checkbox" name="robots[]" value="<?=$robot['id'] ?>" <?php if(!empty($action->filters[$action->id_types['robots']])) if(!empty($action->filters[$action->id_types['robots']][$robot['id']])) echo 'checked' ?>><li><?= $robot["name"] ?></li></label></div>
															<?php
														}
													?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							<a onclick="deleteParams()"><?= $action->trans->read("workshops","deleteFilter") ?></a>
						</div>
					</aside>
					<main>
						<div class="sheet">
							<div id="workshop-form">


								<input type="text" name="name" id="input-h1" placeholder="Title" value="<?php if($workshopExist) echo $action->workshop["name"]  ?>">
								<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onkeyup="limitText(this,512);" onkeypress="limitText(this,512);" onkeydown="limitText(this,512);"><?php if($workshopExist) echo $action->workshop["content"]?></textarea>
								(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">512</div> left.

								<br>
								<div class="infos">




									<div id="current-media">
										<?php
											if($workshopExist)
											{
												loadMedia($action->workshop);
											}
										?>
									</div>

									<input type="hidden" name="media_path" id="media_path" value="<?php if($workshopExist) { echo $action->workshop["media_path"]; } ?>">
									<input type="hidden" name="media_type" id="media_type" value="<?php if($workshopExist) { echo $action->workshop["media_type"]; } ?>">

									<div id="drop-workshop" class="dropzone"></div>

										<input type="hidden" name="deployed" value="false">
										<p><span class="input-title">Deployed</span> <input type="checkbox" name="deployed" id="deployed" value='true' <?php if($workshopExist) {?> onchange="this.name;openConfirmBox(this.parentElement,{type:'ajax',path:'ajax/workshops-ajax.php', params:{ id:<?=$action->workshop['id']?> , deployed:this.checked}});" <?php } ?> <?php if($action->workshop["deployed"]) echo 'checked'; ?>></p>
								</div>
								<div id="params">

								</div>
								<button type="submit" class="submit-btn" name="push"><?php if($workshopExist) echo 'Apply'; else echo 'Add'; ?></button>

								<?php
									if($workshopExist)
									{
										?>
											<button type="submit" class="delete-btn" name="delete">Delete</button>
										<?php
									}
								?>
							</div>
						</div>
					</main>
				</form>
				<?php
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
							<?php
								loadMedia($action->workshop);
							?>
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