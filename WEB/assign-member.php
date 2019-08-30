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
					if($famWork["id_workshop"] == $workshop["id"] )
					{
						if($famWork["id_statut"] != 1 )
						{
							$valide = false;
						}
					}
				}
				if($valide == true)
				{
					?>
						<div class="workshop-object" id="<?= $workshop["id"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["name"] ?></h5></div>
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
					if($famWork["id_workshop"] == $workshop["id"] && $famWork["id_statut"] == 2 )
					{
						?>
							<li class="workshop-object" id="<?= $workshop["id"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["name"] ?></h5></li>
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
					if($famWork["id_workshop"] == $workshop["id"] && $famWork["id_statut"] == 3 )
					{
						?>
							<li class="workshop-object" id="<?= $workshop["id"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["name"] ?></h5></li>
						<?php
					}
				}
			}
		?>
	</ul>

	<a id="manage-btn" href="manage-member.php"><?= $action->trans->read("all_pages","back") ?></a>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");