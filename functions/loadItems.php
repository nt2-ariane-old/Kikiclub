<?php

function loadMedia( $workshop ){
  ?>
    <div class="media">
			<?php
				if($workshop["media_type"] == "mp4"
				|| $workshop["media_type"] == "mov"
				|| $workshop["media_type"] == "avi"
				|| $workshop["media_type"] == "flv"
				|| $workshop["media_type"] == "wmv")
				{
			?>
				<video class="img-rounded" width="100%" height="100%" controls>
					<source src="<?=$workshop["media_path"]?>" type="video/<?= $workshop["media_type"] ?>">
						Your browser does not support the video tag.
					</video>
			<?php
				} else if ($workshop["media_type"] == "png" ||
							$workshop["media_type"] == "jpg" ||
							$workshop["media_type"] == "jpeg" ||
							$workshop["media_type"] == "bmp" ||
							$workshop["media_type"] == "tiff" ||
							$workshop["media_type"] == "gif")
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
		<strong><?= $action->trans->read("all_pages","difficulty")?> : </strong>
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

function loadMemberWorkshops($workshops,$name,$action)
{
	?>
	<div class="container">
		<div class="row line" id="<?= $name ?>">
			<?php
				foreach ($workshops as $workshop) {
			?>
				<div class="col-lg-2">
					<a onclick="openModal();openWorkshop(<?= $workshop['id'] ?>)" ><div class="workshop" >
						<!-- <a href="workshop-infos.php?workshop_id=<?= '..'//$workshop["id"] ?>" ><div class="workshop" > -->
						<?php
							loadMedia($workshop);
						?>
						<h4><?= $workshop["name"] ?></h4>
					</div></a>
				</div>
			<?php
				}
			?>
		</div>
		<?php
			if(sizeof($workshops) > 6)
			{
				?>
					<a  class="link-collapse" onclick="show('<?= $name ?>',this)"><?= $action->trans->read("member-home","show-more") ?></a>
				<?php
			}
		?>
	</div>
	<?php
}