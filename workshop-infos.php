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

				loadWorkshopsCreator($action->workshop,$action);

			}
			else
			{
				if(!empty($action->workshop))
				{
					?>
						<div class="workshop" id="workshop-infos">
							<script>loadMedia(<?= json_encode($action->workshop) ?>,document.getElementById("workshop-infos") )</script>
							<div class="infos" id="infos">
								<h2><?= $action->workshop["NAME"] ?></h2>
								<script>loadStars(<?= json_encode($action->workshop) ?>,document.getElementById("infos") )</script>
								<p><?=  $action->workshop["CONTENT"]?></p>
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
			<a href="workshops.php" class="return-btn">Back</a>
		</div>
		<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");