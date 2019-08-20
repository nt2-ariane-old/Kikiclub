<?php

function loadMedia( $workshop ){
  ?>
    <div class="media">
			<?php
				if($workshop["media_type"] == "mp4")
				{
			?>
				<video class="img-rounded" width="100%" height="100%" controls>
					<source src="<?=$workshop["media_path"]?>" type="video/<?= $workshop["media_type"] ?>">
						Your browser does not support the video tag.
					</video>
			<?php
				} else if ($workshop["media_type"] == "png" ||
					        $workshop["media_type"] == "jpg")
				{
			?>
					<img class="img-rounded" src="<?=$workshop['media_path']?>" alt="">
			<?php
				}
				else if($workshop["media_type"] == "mp3")
				{
			?>
					<audio class="img-rounded" src="<?=$workshop["media_path"]?>" controls="controls">
						Your browser does not support the audio element.
					</audio>
			<?php
				}
			?>
		</div>
  <?php
}

function loadStars($workshop_difficulties,$action ){
	?>
			<strong><?= $action->trans->read("workshops","difficulty")?> : </strong>
	<?php
	$i = 0;
	if(!empty($workshop_difficulties))
	foreach ($workshop_difficulties as $difficulty) {
		if($i > 0)
		{
			?>
				<strong style="padding:1em">OR</strong>
			<?php
		}
		?>

	<div class="stars">
		<?php
		for($i = 1 ; $i <= sizeof($action->difficulties); $i++)
		{
			if( $i <= $difficulty["id_filter"])
			{
				?>
					<span class="fa fa-star checked"></span>
				<?php
			}
			else
			{
				?>
					<span class="fa fa-star"></span>
				<?php
			}
		}
		?>
	</div>
	<?php
		$i++;
		}
}

function loadProfil($user,$action)
{
	$userExist = false;
	if($user != null)
	$userExist = true;
	?>
		<div class="users-contents">
			<?php
			if($action->error)
			{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
			}
			?>
			<div class="sheet">
				<h3>Profil</h3>
				<form id="profil-form" action="manage-member.php" method="post">
					<div class="infos">
						<p><input type="text" name="firstname" id="firstname" placeholder="<?= $action->trans->read("main","firstnameInput") ?>" value="<?php if($userExist) echo $user["firstname"]  ?>"></p>
						<p><input type="text" name="lastname" id="lasttname" placeholder="<?= $action->trans->read("main","lastnameInput") ?>"  value="<?php if($userExist) echo $user["lastname"]  ?>"></p>
						<p><input type="text" name="birth" id="datepicker" placeholder="<?= $action->trans->read("main","birthInput") ?>"  value="<?php if($userExist) echo $user["birthday"]  ?>"></p>

						<p><span class="input-title">Gender : </span>
								<select name="gender" id="">
									<?php
										foreach ($action->genders as $gender) {
											?>
												<option <?php if($userExist)if($user["id_gender"] == $gender["id"]) echo 'selected' ;?> value="<?= $gender["id"] ?>"><?= $gender["name"] ?></option>
											<?php
										}
									?>
								</select></p>
						</div>

						<h3><?= $action->trans->read("users","selectAvatar") ?></h3>

						<div id="mixedSlider_avatars" class="multislider avatars-list">
							<div class="MS-content">
								<?php
									foreach ($action->avatars as $avatar) {
								?>
									<div class="item">
										<label>
											<?php
												if($userExist && $user["id_avatar"] ==  $avatar["id"]){
													?>
														<input type="radio" name="avatar" value="<?=$avatar["id"]?>" checked>
													<?php
												}
												else
												{
													?>
														<input type="radio" name="avatar" value="<?=$avatar["id"]?>">
													<?php
												}
											?>
											<img  style="cursor:pointer;" src="<?=$avatar["media_path"]?>">
										</label>
									</div>
								<?php
									}
								?>
							</div>
							<div class="MS-controls">
								<button type="button" id="btn-left" class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
								<button type="button" id="btn-right" class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
							</div>
						</div>

						<div class="forms-btns">
							<button type="submit" class="submit-btn"><?php if($userExist){echo $action->trans->read("main","update");} else{echo $action->trans->read("main","add");} ?></button>
							<?php
							if($userExist)
							{
								?>
									<a class="delete-btn" style="cursor:pointer;" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement,{type:'post',path:'manage-member.php',params:{ 'delete':true}})"><?= $action->trans->read("main","delete")?></a>

								<?php
							}
						?>
						</div>
					</form>
					<?php
						if($action->admin_mode && $userExist)
						{
							?>
								<a class="return-btn" href="assign-member.php")>Assign Workshop to family member</a>
							<?php
						}
					?>
					<div>
						<a class="return-btn" href="<?= $action->previous_page ?>.php"><?= $action->trans->read("users","return") ?></a>
					</div>


				</div>

			</div>
	<?php
}

function loadWorkshopsCreator($workshop, $action)
{
	$workshopExist = false;
	if($workshop != null)
		$workshopExist = true;
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


					<input type="text" name="name" id="input-h1" placeholder="Title" value="<?php if($workshopExist) echo $workshop["name"]  ?>">
					<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onkeyup="limitText(this,512);" onkeypress="limitText(this,512);" onkeydown="limitText(this,512);"><?php if($workshopExist) echo $workshop["content"]?></textarea>
					(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">512</div> left.

					<br>
					<div class="infos">




						<div id="current-media">
							<?php
								if($workshopExist)
								{
									loadMedia($workshop);
								}
							?>
						</div>

						<input type="hidden" name="media_path" id="media_path" value="<?php if($workshopExist) { echo $workshop["media_path"]; } ?>">
						<input type="hidden" name="media_type" id="media_type" value="<?php if($workshopExist) { echo $workshop["media_type"]; } ?>">

						<div id="drop-workshop" class="dropzone"></div>

							<input type="hidden" name="deployed" value="false">
							<p><span class="input-title">Deployed</span> <input type="checkbox" name="deployed" id="deployed" value='true' <?php if($workshopExist) {?> onchange="this.name;openConfirmBox(this.parentElement,{type:'ajax',path:'ajax/workshops-ajax.php', params:{ id:<?=$workshop['id']?> , deployed:this.checked}});" <?php } ?> <?php if($workshop["deployed"]) echo 'checked'; ?>></p>
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
function loadRobotEditor($robot,$action)
{
	$exist = false;
	if($robot != null)
	{
		$exist = true;
	}
	?>
		<form id="profil-form" action="robot-infos.php" method="post">
			<div class="robot-infos">
				<h5>Robot informations</h3>
				<input class="h2" type="text" name="name" placeholder="Name" <?php if($exist){ ?>value="<?=$action->robot["robots"]["name"]?>" <?php } ?>>
				<div id=current-media>
					<?php
						if($exist)
						{
							loadMedia($action->robot["robots"]);
						}
					?>
				</div>

				<div id="imagedropzone" class="dropzone"></div>
				<input type="hidden" name="media_path" id="media_path" <?php if($exist){ ?>value="<?=$action->robot["robots"]["media_path"]?>" <?php } ?>>
				<input type="hidden" name="media_type" id="media_type" <?php if($exist){ ?>value="<?=$action->robot["robots"]["media_type"]?>" <?php } ?>>
				<p> <span class="input_name"> Age Recommanded :</span>
					<select name="grade_recommanded">
									<?php
										foreach ($action->grades as $grade) {
											?>
												<option value="<?= $grade["id"]?>"  <?php if($exist){ if($action->robot["robots"]["id_grade"] == $grade["id"]) { echo 'selected'; } }?>><?= $grade["name"]?></option>
												<?php
										}
										?>

								</select>

							</p>
							<textarea name="description" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onkeyup="limitText(this,512);" onkeypress="limitText(this,512);" onkeydown="limitText(this,512);"><?php if($exist) {echo $action->robot ["robots"]["description"];}?></textarea>
							<p>(Maximum characters: 125). You have <span style="display:inline-block;" id="countdown">512</span> left.</p>
						</div>
						<div class="robot-infos">


							<br>
							<h5>Scores by difficulties when workshop completed</h3>
							<?php
								if($exist)
								{
									foreach ($action->robot["scores"] as $score) {
										?>
											<p><span class="input_name"><?= $score["difficulty"]?></span><input type="number" name="score_<?= $score["id_difficulty"]?>" placeholder="Score" value="<?= $score["score"]?>"></p>
											<?php
									}
								}
								else
								{
									foreach ($action->difficulties as $difficulty) {
									?>
										<p><span class="input_name"><?= $difficulty["name"]?></span><input type="number" name="score_<?= $difficulty["id"]?>" placeholder="Score"></p>
									<?php
									}
								}
							?>


								<button type="submit" class="submit-btn" name="push" onclick="clicked=this.name">Apply</button>
								<?php
									if($action->update)
									{
										?>
											<button type="submit" class="delete-btn" name="delete" onclick="clicked=this.name">Delete</button>
											<?php
									}
									?>
						</div>
							</form>
	<?php
}
$nbWorkshops = 4;
function loadWorkshopsCarousel($workshops,$name,$action,$title)
{

	?>
		<div id="<?= $name  ?>" class="carousel slide" >
			<!-- Content -->
			<div class="carousel-inner">
			<?php
				for ($i=0; $i < sizeof($workshops); $i++) {
					?>
					<div class="carousel-item <?php if($i == 0) echo 'active';?>">
						<div class="container">
							<div class="row">
							<?php
								$j = $i;
								for($i; $i < $j + $nbWorkshops  && $i < sizeof($workshops); $i++)
								{
									$workshop = $workshops[$i];
							?>

									<div class="workshop col-sm-<?= 12/$nbWorkshops ?>" >
									<?php
										loadMedia($workshop);
									?>
									<h4><?= $title ?> workshop</h3>
									<div class="title"><h2><?= $workshop["name"] ?></h4></div>

									<h5>Type : <?= $action->robots[$workshop["id_ROBOT"]]["name"] ?></h5>
									<?php
										loadStars($workshop);
									?>

								</div>
							<?php

							}
							?>
							</div>
						</div>
					</div>
					<?php
				}

			?>
		   </div>
		   <!-- Controls -->
		   <a class="carousel-control-prev" href="#<?= $name  ?>" role="button" data-slide="prev">
		     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		     <span class="sr-only">Previous</span>
		   </a>
		   <a class="carousel-control-next" href="#<?= $name  ?>" role="button" data-slide="next">
		     <span class="carousel-control-next-icon" aria-hidden="true"></span>
		     <span class="sr-only">Next</span>
		   </a>
		</div>
	<?php
}

function loadBadgesLine($badges,$name,$action,$title,$isMember=false)
{
	$nbBadges = 4;
	?>
	<div class="container">
		<div class="row" id="<?= $title ?>">
		<?php
			foreach ($badges as $badge) {
				?>
				<div class="col-sm-<?= 12/$nbBadges ?>" >
			<div <?php if($action->admin_mode) { ?> onclick='clicBadge(this,<?= json_encode($badge)?>)' <?php } ?> class = "kikiclub-badge">
						<h5><?= $badge["name"] ?></h5>
						<?php
							loadMedia($badge);
						?>
						<?php
							if($isMember)
							{
						?>
								<h6>Won on <?= $badge["won_on"]?></h6>
						<?php
							}
						?>
					</div>

				</div>
				<?php
			}
		?>
		</div>
	</div>
	<?php

}

function loadBadgesSlider($won_badges,$all_badges,$name,$action,$title,$idMember=false)
{
	?>
	<div id="mixedSlider_badges" class="multislider">
		<div class="MS-content">
			<?php
				foreach ($all_badges as $badge) {
					?>
					<div class="item">
						<div  <?php if(array_key_exists($badge["id"], $won_badges)) { ?> onclick="openModal();openBadge(<?= $badge['id'] ?>)" style="cursor:pointer;" <?php } ?>>
							<div class="kikiclub-badge <?php if(!array_key_exists($badge["id"], $won_badges)) { echo 'blured'; } ?>">
								<?php loadMedia($badge)?>
							</div>
						</div>
					</div>

					<?php
				}
			?>
		</div>
		<div class="MS-controls">
			<button id="btn-left" class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
			<button id="btn-right" class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
		</div>
	</div>

	<?php
}
function loadBadgesCarousel($won_badges,$all_badges,$name,$action,$title,$isMember=false)
{
	$nbBadges = 4;
	?>
		<div id="<?= $name  ?>" class="carousel slide" >
			<!-- Content -->
			<div class="carousel-inner">
			<?php
				for ($i=0; $i < sizeof($all_badges); $i++) {
					?>
					<div class="carousel-item <?php if($i == 0) echo 'active';?>">
						<div class="container">
							<div class="row">
							<?php
								$j = $i;

								for ($i=$j; $i < sizeof($all_badges) && $i < $j + $nbBadges; $i++) {
									$badge = $all_badges[$i];
							?>
									<div onclick="openModal();openBadge(<?= $badge['id'] ?>)" class="kikiclub-badge <?php if(!array_key_exists($badge["id"], $won_badges)) { echo 'blured'; } ?> col-sm-<?= 12/$nbBadges ?>" >
									<?php
										loadMedia($badge);
									?>

								</div>
							<?php

							}
							?>
							</div>
						</div>
					</div>
					<?php
				}

			?>
		   </div>
		   <!-- Controls -->
		   <a class="carousel-control-prev" href="#<?= $name  ?>" role="button" data-slide="prev">
		     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		     <span class="sr-only">Previous</span>
		   </a>
		   <a class="carousel-control-next" href="#<?= $name  ?>" role="button" data-slide="next">
		     <span class="carousel-control-next-icon" aria-hidden="true"></span>
		     <span class="sr-only">Next</span>
		   </a>
		</div>
	<?php
}


function loadWorkshopsLine($workshops,$name,$action,$title)
{
	$nbWorkshopsS = 1;
	$nbWorkshopsM = 2;
	$nbWorkshopsL = 4;


	?>
	<div class="container">
		<div class="row">
			<?php
			for ($i=0; $i < sizeof($workshops); $i++) {
				$workshop = $workshops[$i];
				?>
					<div class="workshop col-md-<?= 12/$nbWorkshopsS ?>  col-md-<?= 12/$nbWorkshopsM ?> col-md-<?= 12/$nbWorkshopsL ?> " >

						<?php
							loadMedia($workshop);
						?>
						<div class="title"><h2><?= $workshop["name"] ?></h4></div>
					</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}