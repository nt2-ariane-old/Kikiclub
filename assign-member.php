<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/AssignMemberAction.php");

	$action = new AssignMemberAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>

	<ul id="new" class="droppable Workshop-boxes">
		<?php
			foreach ($action->workshops_deployed as $workshop)
			{
				$valide = true;
				foreach ($action->member_workshops as $famWork)
				{
					if($famWork["ID_WORKSHOP"] == $workshop["ID"] )
					{
						if($famWork["ID_STATUT"] != 1 && $famWork["ID_STATUT"] != 2 )
						{
							$valide = false;
						}
					}
				}
				if($valide == true)
				{
					?>
						<div class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></div>
					<?php
				}
			}
		?>
	</ul>



	<ul id="in-progress" class="droppable Workshop-boxes">
		<?php
			foreach ($action->workshops_deployed as $workshop)
			{
				foreach ($action->member_workshops as $famWork)
				{
					if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["ID_STATUT"] == 3 )
					{
						?>
							<li class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></li>
						<?php
					}
				}
			}
		?>
	</ul>

	<ul id="complete" class="droppable Workshop-boxes">
		<?php
			foreach ($action->workshops_deployed as $workshop)
			{
				foreach ($action->member_workshops as $famWork)
				{
					if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["ID_STATUT"] == 4 )
					{
						?>
							<li class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></li>
						<?php
					}
				}
			}
		?>
	</ul>

	<a id="manage-btn" href="manage-member.php">Back</a>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");