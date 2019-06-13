<?php
	require_once("action/WorkshopsAction.php");

	$action = new WorkshopsAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<link rel="stylesheet" href="css/workshops.css">

		<?php
		if($action->show_workshop)
		{
			?>
			<div class="workshop-section">
			<?php
				if($action->workshop["MEDIA_TYPE"] == "mp4")
				{
			?>
					<video width="600" height="400" controls>
						<source src="<?= $action->workshop["MEDIA_PATH"] ?>" type="video/<?= $action->workshop["MEDIA_TYPE"] ?>">
						Your browser does not support the video tag.
					</video>
			<?php
				} else if ($action->workshop["MEDIA_TYPE"] == "png" ||
					$action->workshop["MEDIA_TYPE"] == "jpg")
				{
			?>
					<img style="width:100px;" src=<?=$action->workshop["MEDIA_PATH"]?> alt="">
			<?php
				}
				else if($action->workshop["MEDIA_TYPE"] == "mp3")
				{
			?>
					<audio src="<?=$action->workshop["MEDIA_PATH"]?>" controls="controls">
						Your browser does not support the audio element.
					</audio>
			<?php
				}
			?>
				<h2><?=  $action->workshop["NAME"]?></h2>
				<div class="stars">
					Difficulty :
					<?php
						for($i = 0 ; $i < 3; $i++)
						{
							if( $i <= $action->workshop["DIFFICULTY"])
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
				<p><?=  $action->workshop["CONTENT"]?></p>
				<form action="workshops" method="post"></form>
				<?php
					foreach ($action->questions as $question) {
					?>
						<div class="question">
							<p><?= $question["QUESTION"] ?></p>
							<input type="text" name="<?=$question["ID"]?>">
						</div>
					<?php
					}
				?>
			</div>

			<a id="manage-btn" href="workshops.php">Return to Workshops</a>
			<?php
		}
		else
		{
			?>
			<div class="workshops-list">
			<?php
			foreach($action->workshops_list as $workshop)
			{
				?>
					<a href="?workshop=<?= $workshop["ID"] ?>"><div class="workshop">
						<div class="media">
						<?php
							if($workshop["MEDIA_TYPE"] == "mp4")
							{
						?>
								<video width="500" height="350" controls>
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
						<h2><?=$workshop["NAME"]?></h2>
						<div class="description"><p><?=$workshop["CONTENT"]?></p></div>
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
					</div></a>
				<?php
			}
			?>
			</div>
			<a id="manage-btn" href="users.php">Return to Profiles</a>
			<?php
		}
		?>

<?php
	require_once("partial/footer.php");