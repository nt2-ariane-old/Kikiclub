<?php

function loadMedia( $workshop ){
  ?>
    <div class="media">
			<?php
				if($workshop["MEDIA_TYPE"] == "mp4")
				{
			?>
				<video width="100%" height="100%" controls>
					<source src="<?= $workshop["MEDIA_PATH"] ?>" type="video/<?= $workshop["MEDIA_TYPE"] ?>">
						Your browser does not support the video tag.
					</video>
			<?php
				} else if ($workshop["MEDIA_TYPE"] == "png" ||
					        $workshop["MEDIA_TYPE"] == "jpg")
				{
			?>
					<img src=<?=$workshop["MEDIA_PATH"]?> alt="">
			<?php
				}
				else if($workshop["MEDIA_TYPE"] == "mp3")
				{
			?>
					<audio src="<?=$workshop["MEDIA_PATH"]?>" controls="controls">
						Your browser does not support the audio element.
					</audio>
			<?php
				}
			?>
		</div>
  <?php
}

function loadStars( $workshop ){

	?>
	<div class="stars">
		Difficulty :
	<?php
	for($i = 0 ; $i < 3; $i++)
	{

		if( $i <= $workshop["DIFFICULTY"])
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
		<div class="register-contents">
			<?php
			if($action->error)
			{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
			}
			?>

				<form action="<?=$action->page_name?>.php" method="post">
						<input type="hidden" name="form" value="create">
						<?php
							if($action->page_name=='console')
							{
								?>
									<input type="hidden" name="users">
								<?php
								if($action->modify)
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
						?>
						<input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php if($userExist) echo $user["firstname"]  ?>">
						<input type="text" name="lastname" id="lasttname" placeholder="Last Name"  value="<?php if($userExist) echo $user["lastname"]  ?>">
						<input type="text" name="birth" id="datepicker" placeholder="Birthday"  value="<?php if($userExist) echo $user["birthday"]  ?>">
						<select name="gender" id="">
							<option <?php if($userExist)if($user["gender_id"] == 0) echo 'selected' ;?> value="0">Male</option>
							<option <?php if($userExist)if($user["gender_id"] == 1) echo 'selected' ;?> value="1">Female</option>
							<option <?php if($userExist)if($user["gender_id"] == 2) echo 'selected' ;?> value="2">Other</option>
							<option <?php if($userExist)if($user["gender_id"] == 3) echo 'selected' ; ?>  value="3">Do not specify</option>
						</select>

						<p>Select Avatar :</p>
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
							<button type="submit" class="submit-btn"><?php if($userExist){echo "Update";} else{echo 'Add';} ?></button>
						</div>
					</form>

					<button class="delete-btn" onclick="location.href='<?php if($userExist){echo '?delete=true';} else{echo '?mode=manage';} ?>';"><?php if($userExist){echo 'Delete';} else{echo 'Back';} ?></button>
	<?php
}

function loadWorkshops($list)
{
	foreach($list as $workshop)
	{
		?>

			<a href="?workshop=<?= $workshop["ID"] ?>"><div class="workshop">
				<?php
					loadMedia($workshop);
				?>
				<h2><?=$workshop["NAME"]?></h2>
				<div class="description"><p><?=$workshop["CONTENT"]?></p></div>

				<?php
					loadStars($workshop);
				?>

			</div></a>
		<?php
	}
}