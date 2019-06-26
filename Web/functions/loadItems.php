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

				<form action="<?php if($action->page_name == 'show-users') echo 'users'; else $action->page_name; ?>.php" method="post">
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
										<input type="hidden" name="modify">
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
								if($action->modify)
								{
									?>
										<input type="hidden" name="modify">
									<?php
								}
								else
								{
									?>
										<input type="hidden" name="add">
									<?php
								}
							}
						?>
						<input type="text" name="firstname" id="firstname" placeholder="<?= $action->trans->read("main","firstnameInput") ?>" value="<?php if($userExist) echo $user["firstname"]  ?>">
						<input type="text" name="lastname" id="lasttname" placeholder="<?= $action->trans->read("main","lastnameInput") ?>"  value="<?php if($userExist) echo $user["lastname"]  ?>">
						<input type="text" name="birth" id="datepicker" placeholder="<?= $action->trans->read("main","birthInput") ?>"  value="<?php if($userExist) echo $user["birthday"]  ?>">
						<select name="gender" id="">
							<option <?php if($userExist)if($user["gender_id"] == 0) echo 'selected' ;?> value="0">Male</option>
							<option <?php if($userExist)if($user["gender_id"] == 1) echo 'selected' ;?> value="1">Female</option>
							<option <?php if($userExist)if($user["gender_id"] == 2) echo 'selected' ; ?>  value="2">Do not specify</option>
						</select>

						<p><?= $action->trans->read("users","selectAvatar") ?></p>
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
						</div>
					</form>

					<?php
						if($userExist)
						{
							?>
								<button class="delete-btn" onclick="post('users.php',{ 'delete':true});"><?= $action->trans->read("main","delete")?></button>
							<?php
						}
					?>
			</div>
	<?php
}

function loadWorkshopsCreator($workshop, $action)
{
	$workshopExist = false;
	if($workshop != null)
		$workshopExist = true;
	?>
		<div class="form-workshops">
			<form action="console.php" method="post" enctype="multipart/form-data">
				<?php
					if($workshopExist)
					{
						?>
							<input type="hidden" name="modify">
						<?php
					}
					else
					{
						?>
							<input type="hidden" name="add">
						<?php
					}
				?>

				<input type="hidden" name="workshops">
				<input type="hidden" name="workshops_list[]" value="<?=$workshop["ID"]?>"></td>

						<input type="text" name="name" placeholder="Title" value="<?php if($workshopExist) echo $workshop["NAME"]  ?>">
						<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onKeyDown="limitText(this.form.content,125);" onKeyUp="limitText(this.form.content,125);"><?php if($workshopExist) echo $workshop["CONTENT"]?></textarea>
						(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">125</div> left.

						<br>
						<?= $action->trans->read('workshops','difficulty') ?>
						<select name="difficulty">
							<?php
								foreach ($action->difficulties as $difficulty) {
									?>
										<option value=<?= $difficulty["ID"]?> <?php if($workshopExist && $workshop["ID_DIFFICULTY"] ==  $difficulty["ID"]) echo 'selected' ;?>><?= $difficulty["NAME"]?></option>

									<?php
								}
							?>
							</select>

							Robot:
							<select name="robot">
							<?php
								foreach ($action->robots as $robot) {
									?>
										<option value=<?= $robot["ID"]?> <?php if($workshop["ID_ROBOT"] ==  $robot["ID"]) echo 'selected' ;?>><?= $robot["NAME"]?></option>
									<?php
								}
							?>
							</select>
						<div id="questions">
							<input type="hidden" name="nbQuestions" value=0 id="nbQuestions">
						</div>
						<a onclick="addquestion()">Add Question</a>


						<!-- <input type="hidden" name="MAX_FILE_SIZE" value="100000" /> -->
						Choose Workshop Image: <input name="workshopFile" type="file" /><br />

						<button type="submit" name="push"><?php if($workshopExist) echo 'Modify'; else echo 'Add'; ?></button>
						<button type="submit" name="back">Back</button>
					</form>
				</div>
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


function loadWorkshopsLine($workshops,$name,$action,$title)
{
	$nbWorkshops = 4;
	?>
	<div class="container">
		<div class="row">
			<?php
			for ($i=0; $i < sizeof($workshops); $i++) {
				$workshop = $workshops[$i];
				?>
					<div class="workshop col-sm-<?= 12/$nbWorkshops ?>" >
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