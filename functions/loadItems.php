<?php

function loadMedia( $workshop ){
  ?>
    <div class="media">
			<?php
				if($workshop["MEDIA_TYPE"] == "mp4")
				{
			?>
				<video class="img-rounded" width="100%" height="100%" controls>
					<source src="<?=$workshop["MEDIA_PATH"]?>" type="video/<?= $workshop["MEDIA_TYPE"] ?>">
						Your browser does not support the video tag.
					</video>
			<?php
				} else if ($workshop["MEDIA_TYPE"] == "png" ||
					        $workshop["MEDIA_TYPE"] == "jpg")
				{
			?>
					<img class="img-rounded" src=<?=$workshop["MEDIA_PATH"]?> alt="">
			<?php
				}
				else if($workshop["MEDIA_TYPE"] == "mp3")
				{
			?>
					<audio class="img-rounded" src="<?=$workshop["MEDIA_PATH"]?>" controls="controls">
						Your browser does not support the audio element.
					</audio>
			<?php
				}
			?>
		</div>
  <?php
}

function loadStars($workshop,$action ){

	?>
	<div class="stars">
		<?= $action->trans->read("workshops","difficulty")?> :
	<?php
	for($i = 0 ; $i < 3; $i++)
	{

		if( $i <= $workshop["ID_DIFFICULTY"])
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
				<h2>Profil de <?= $user["firstname"] ?></h2>
				<form id="profil-form" action="manage-member.php" method="post">
						<input type="hidden" name="form">
						<?php
							if($action->page_name=='console')
							{
								?>
									<input type="hidden" name="users">
								<?php
								if($action->modFamily)
								{
									?>
										<input type="hidden" name="update">
										<input type="hidden" name="members_list[]" value="<?=$user["ID"]?>">
									<?php
								}
								else
								{
									?>
										<input type="hidden" name="addFamily">
										<input type="hidden" name="users_list[]" value="<?=$action->userMod?>">
									<?php
								}
							}
							else
							{
								if($action->update)
								{
									?>
										<input type="hidden" name="action" value="update">
									<?php
								}
								else if ($action->create)
								{
									?>
										<input type="hidden" name="action" value="create">
									<?php
								}
								else
								{
									?>
										<script>window.location="users.php"</script>
									<?php
								}
							}
						?>
						<div class="infos">
							<p><span class="input-title"><?= $action->trans->read("main","firstnameInput") ?> : </span><input type="text" name="firstname" id="firstname" placeholder="<?= $action->trans->read("main","firstnameInput") ?>" value="<?php if($userExist) echo $user["firstname"]  ?>"></p>
							<p><span class="input-title"><?= $action->trans->read("main","lastnameInput") ?> : </span><input type="text" name="lastname" id="lasttname" placeholder="<?= $action->trans->read("main","lastnameInput") ?>"  value="<?php if($userExist) echo $user["lastname"]  ?>"></p>
							<p><span class="input-title"><?= $action->trans->read("main","birthInput") ?> : </span><input type="text" name="birth" id="datepicker" placeholder="<?= $action->trans->read("main","birthInput") ?>"  value="<?php if($userExist) echo $user["birthday"]  ?>"></p>
							<p><span class="input-title">Gender : </span>
								<select name="gender" id="">
									<?php
										foreach ($action->genders as $gender) {
											?>
												<option <?php if($userExist)if($user["id_gender"] == $gender["ID"]) echo 'selected' ;?> value="<?= $gender["ID"] ?>"><?= $gender["NAME"] ?></option>
											<?php
										}
									?>
								</select></p>
						</div>

						<p><span class="input-title"><?= $action->trans->read("users","selectAvatar") ?></span></p>
						<div class="avatars-list">
							<?php
								foreach( $action->avatars as $avatar)
								{
									?>
									<label>
										<?php
											if($userExist)
											{
												if($user["id_avatar"] ==  $avatar["ID"]){
												?>
													<input type="radio" name="avatar" value="<?=$avatar["ID"]?>" checked>

												<?php
												}
												else
												{
													?>
														<input type="radio" name="avatar" value="<?=$avatar["ID"]?>">
													<?php
												}
											}
											else
											{
												?>
													<input type="radio" name="avatar" value="<?=$avatar["ID"]?>">
												<?php
											}
										?>
										<img src="<?=$avatar["PATH"]?>">
									</label>

									<?php
								}
							?>
						</div>
						<div class="forms-btns">
							<button type="submit" class="submit-btn"><?php if($userExist){echo $action->trans->read("main","update");} else{echo $action->trans->read("main","add");} ?></button>
							<?php
							if($userExist)
							{
								?>
									<a class="delete-btn" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement,{type:'post',path:'manage-member.php',params:{ 'delete':true}})"><?= $action->trans->read("main","delete")?></a>

								<?php
							}
						?>
						</div>
					</form>
					<?php
						if($action->page_name == 'console' && $userExist)
						{
							?>

							<?php
						}
						else
						{
							?>
								<div>
									<a class="return-btn" href="<?= $action->previous_page ?>.php"><?= $action->trans->read("users","return") ?></a>
								</div>
							<?php
						}
					?>

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
	<form action="workshop-infos.php" id="workshop-form" method="post" enctype="multipart/form-data">
		<input type="text" name="name" id="input-h1" placeholder="Title" value="<?php if($workshopExist) echo $workshop["NAME"]  ?>">
		<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onkeyup="limitText(this,512);" onkeypress="limitText(this,512);" onkeydown="limitText(this,512);"><?php if($workshopExist) echo $workshop["CONTENT"]?></textarea>
		(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">512</div> left.

		<br>
		<div class="infos">
			<p><span class="input-title"><?= $action->trans->read("workshops","difficulty") ?> : </span><select name="difficulty">
				<?php
					foreach ($action->difficulties as $difficulty)
					{
						?>
							<option value=<?= $difficulty["ID"]?> <?php if($workshopExist && $workshop["ID_DIFFICULTY"] ==  $difficulty["ID"]) echo 'selected' ;?>><?= $difficulty["NAME"]?></option>
						<?php
					}
				?>
			</select></p>

			<p><span class="input-title"><?= $action->trans->read("workshops","robots") ?> : </span><select name="robot">
				<?php
					foreach ($action->robots as $robot)
					{
						?>
							<option value=<?= $robot["ID"]?> <?php if($workshop["ID_ROBOT"] ==  $robot["ID"]) echo 'selected' ;?>><?= $robot["NAME"]?></option>
						<?php
					}
				?>
			</select></p>

			<div id="current-media">
				<?php
					if($workshopExist)
					{
						loadMedia($workshop);
					}
				?>
			</div>

			<input type="hidden" name="media_path" id="media_path" value="<?php if($workshopExist) { echo $workshop["MEDIA_PATH"]; } ?>">
			<input type="hidden" name="media_type" id="media_type" value="<?php if($workshopExist) { echo $workshop["MEDIA_TYPE"]; } ?>">

			<div id="drop-workshop" class="dropzone"></div>

			<p><span class="input-title"><?= $action->trans->read("workshops","grades")  ?> : </span><select name="grade">
				<?php
					foreach ($action->grades as $grade) {
						?>
							<option value=<?= $grade["ID"]?> <?php if($workshop["ID_GRADE"] ==  $grade["ID"]) echo 'selected' ;?>><?= $grade["NAME"]?></option>
						<?php
					}
				?>
			</select></p>

				<p><span class="input-title">Deployed</span> <input type="checkbox" name="deployed" id="deployed" value='true' <?php if($workshopExist) {?> onchange="this.name;openConfirmBox(this.parentElement,{type:'ajax',path:'ajax/workshops-ajax.php', params:{ id:<?=$workshop['ID']?> , deployed:this.checked}});" <?php } ?> <?php if($workshop["DEPLOYED"]) echo 'checked'; ?>></p>
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
	</form>
	<?php
}
$nbWorkshops = 4;
function loadWorkshopsCarousel($workshops,$name,$action,$title)
{

	?>
		<div id="<?= $name  ?>" class="carousel slide" data-ride="carousel">
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
									<div class="title"><h2><?= $workshop["NAME"] ?></h4></div>

									<h5>Type : <?= $action->robots[$workshop["ID_ROBOT"]]["NAME"] ?></h5>
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
		<?php
			for ($i=0; $i < sizeof($badges) / $nbBadges ; $i++) {
				# code...
			}
		?>
		<div class="row" id="<?= $title ?>">
		<?php
			foreach ($badges as $badge) {
				?>
				<div class="kikiclub-badge col-sm-<?= 12/$nbBadges ?>" >
					<?php
						loadMedia($badge);
					?>
					<h5><?= $badge["NAME"] ?></h5>
					<?php
						if($isMember)
						{
					?>
							<h6>Won on <?= $badge["WON_ON"]?></h6>
					<?php
						}
					?>
				</div>
				<?php
			}
		?>
		</div>
	</div>
	<?php

}

function loadBadgesCarousel($badges,$name,$action,$title,$isMember=false)
{
	$nbBadges = 4;
	?>
		<div id="<?= $name  ?>" class="carousel slide" data-ride="carousel">
			<!-- Content -->
			<div class="carousel-inner">
			<?php
				for ($i=0; $i < sizeof($badges); $i++) {
					?>
					<div class="carousel-item <?php if($i == 0) echo 'active';?>">
						<div class="container">
							<div class="row">
							<?php
								$j = $i;

								foreach ($badges as $badge) {
							?>
									<div class="kikiclub-badge col-sm-<?= 12/$nbBadges ?>" >
									<?php
										loadMedia($badge);
									?>
									<h5><?= $badge["NAME"] ?></h5>
									<?php
										if($isMember)
										{
											?>
												<h6>Won on <?= $badge["WON_ON"]?></h6>
											<?php
										}
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
						<div class="type">
							<?php
								if(in_array($workshop, $action->new) ) echo 'New';
								else if(in_array($workshop, $action->completed) ) echo 'Complete';
							 	else if(in_array($workshop, $action->notStarted) ) echo 'Not Started';
								else if(in_array($workshop, $action->inProgress) ) echo 'In Progress';
							?>
						</div>
						<?php
							loadMedia($workshop);
						?>
						<div class="title"><h2><?= $workshop["NAME"] ?></h4></div>
					</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}