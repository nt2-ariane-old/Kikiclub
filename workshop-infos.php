<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/WorkshopInfosAction.php");

	$action = new WorkshopInfosAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	$workshopExist = false;
	if($action->workshop != null)
	{
		$workshopExist = true;
	}
?>
		
	
	<main>
		<div class="sheet">
			<form id="workshop-form" method="POST">
			<aside>
				<div class="filters">
					<span id="x-aside" onclick="closeFilters()">x</span>
					<h2><?= $action->trans->read("workshops","filter") ?></h2>
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
												$i=0;
												foreach ($action->difficulties as $diff) {
													?>
														<div>
															<label>
																<input type="checkbox" name="difficulties[]" value="<?= $diff['id'] ?>" onclick="setSearchParams('difficulties',<?=$diff['id'] ?>)" <?php if(!empty($action->filters[$action->id_types['difficulties']])) if(!empty($action->filters[$action->id_types['difficulties']][$diff['id']])) echo 'checked'; if($i == 0 && empty($action->filters[$action->id_types["difficulties"]])) echo 'checked'; ?>>
																<span></span><li><?= $diff["name"] ?></li>
															</label>
														<div>
													<?php
													$i++;
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
												$i=0;
												foreach ($action->grades as $grade) {
													?>
														<div><label><input type="checkbox" name="grades[]" value="<?= $grade['id'] ?>" onclick="setSearchParams('grades',<?=$grade['id'] ?>)" <?php if(!empty($action->filters[$action->id_types['grades']])) if(!empty($action->filters[$action->id_types['grades']][$grade['id']])) echo 'checked'; if($i == 0 && empty($action->filters[$action->id_types["grades"]])) echo 'checked';?>><span></span><li><?= $grade["name"] ?></li></label></div>
													<?php
													$i++;
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
												$i = 0;
												foreach ($action->robots as $robot) {
													?>
														<div><label><input type="checkbox" name="robots[]" value="<?= $robot['id'] ?>" onclick="setSearchParams('robots',<?=$robot['id'] ?>)" <?php if(!empty($action->filters[$action->id_types['robots']])) if(!empty($action->filters[$action->id_types['robots']][$robot['id']])) echo 'checked'; if($i == 0 && empty($action->filters[$action->id_types["robots"]])) echo 'checked';?>><span></span><li><?= $robot["name"] ?></li></label></div>
													<?php
													$i++;
												}
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</aside>
			<section>

				<input type="text" name="name" id="input-h1" placeholder="Title" value="<?php if($workshopExist) echo $action->workshop["name"]  ?>">
				<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onkeyup="limitText(this,512);" onkeypress="limitText(this,512);" onkeydown="limitText(this,512);"><?php if($workshopExist) echo $action->workshop["content"]?></textarea>
				(Maximum characters: 512). You have <div style="display:inline-block;" id="countdown">512</div> left.
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
					<p><span class="input-title">Deployed :</span> <input type="checkbox" name="deployed" id="deployed" value='true' <?php if($workshopExist) {?> onchange="this.name;openConfirmBox(this.parentElement,{type:'ajax',path:'ajax/workshops-ajax.php', params:{ id:<?=$action->workshop['id']?> , deployed:this.checked}});" <?php } ?> <?php if($action->workshop["deployed"]) echo 'checked'; ?>></p>
					<div id="params"></div>
					<h3>Matériel : </h3>
					<div id="materials">
						<?php
							foreach ($action->materials as $material) {
								?>
									<h4><?= $material["material"] ?></h4>
								<?php
							}
						?>
					</div>
					<button onclick="addMaterial()" type="button">+</button>
					<div class="buttons">
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
			</section>
			</form>
		</main>
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