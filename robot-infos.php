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
											<option value="<?= $grade["ID"]?>"><?= $grade["NAME"]?></option>
										<?php
									}
								?>

							</select>
							</p>

							<?php
								foreach ($action->difficulties as $difficulty) {
									?>
										<p><span class="input_name"><?= $difficulty["NAME"]?></span><input type="number" name="score_<?= $difficulty["ID"]?>" placeholder="Score"></p>
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

								<input type="text" name="name" placeholder="Name" value="<?=$action->robot["ROBOTS"]["NAME"]?>">

								<p> <span class="input_name"> Age Recommanded :</span>
								<select name="grade_recommanded">
									<?php
										foreach ($action->grades as $grade) {
											?>
												<option value="<?= $grade["ID"]?>"><?= $grade["NAME"]?></option>
											<?php
										}
										?>

								</select>
								</p>

								<?php
									foreach ($action->robot["SCORES"] as $score) {
										?>
											<p><span class="input_name"><?= $score["DIFFICULTY"]?></span><input type="number" name="score_<?= $score["ID_DIFFICULTY"]?>" placeholder="Score" value="<?= $score["SCORE"]?>"></p>
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
						<h3><?= $action->robot["NAME"] ?></h3>
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