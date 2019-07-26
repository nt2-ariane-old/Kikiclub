<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/RobotInfosAction.php");

	$action = new RobotInfosAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

	<div class='sheet'>
		<?php

			if($action->admin_mode)
			{

				if($action->add)
				{
					?>
					<div class="sheet">
						<form id="profil-form" action="robot-infos.php" method="post">
							<input type="hidden" name="add">
							<input type="hidden" name="robots">

							<input type="text" name="name" placeholder="Name">

							<p> <span class="input_name"> Age Recommanded :</span>
							<select name="grade_recommanded">
								<?php
									foreach ($action->grades as $grade) {
										?>
											<option value="<?= $grade["id"]?>"><?= $grade["name"]?></option>
										<?php
									}
								?>

							</select>
							</p>

							<?php
								foreach ($action->difficulties as $difficulty) {
									?>
										<p><span class="input_name"><?= $difficulty["name"]?></span><input type="number" name="score_<?= $difficulty["id"]?>" placeholder="Score"></p>
									<?php
								}
							?>
							<button type="submit" name="push" onclick="clicked=this.name">Add</button>
						</form>
					</div>
					<?php
				}
				else if($action->update)
				{
					?>
							<form id="profil-form" action="robot-infos.php" method="post">

								<input type="text" name="name" placeholder="Name" value="<?=$action->robot["robots"]["name"]?>">

								<p> <span class="input_name"> Age Recommanded :</span>
								<select name="grade_recommanded">
									<?php
										foreach ($action->grades as $grade) {
											?>
												<option value="<?= $grade["id"]?>"><?= $grade["name"]?></option>
											<?php
										}
										?>

								</select>
								</p>

								<?php
									foreach ($action->robot["scores"] as $score) {
										?>
											<p><span class="input_name"><?= $score["difficulty"]?></span><input type="number" name="score_<?= $score["id_difficulty"]?>" placeholder="Score" value="<?= $score["score"]?>"></p>
										<?php
									}
									?>
								<button type="submit" name="push" onclick="clicked=this.name">Apply</button>
								<?php
									if($action->update)
									{
										?>
											<button type="submit" name="delete" onclick="clicked=this.name">Back</button>
										<?php
									}
								?>
							</form>

					<?php
				}
			}
			else
			{
				if($action->exist)
				{
					?>
						<h3><?= $action->robot["robots"]["name"] ?></h3>
						<h4>Recommanded Grade : <?= $action->grades[$action->robot["robots"]["id_grade"]]["name"]?></h4>
						<div class="description" ><p><?= $action->robot["robots"]["description"] ?></p></div>
						<div class="media"><img class="img-rounded" src=<?=$action->robot["robots"]["media_path"]?> alt=""></div>
					<?php
				}
				else
				{
					?>
						<h2>The Robot you're looking for doesn't exist</h2>
					<?php
				}
			}
			?>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");