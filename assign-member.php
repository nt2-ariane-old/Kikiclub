<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/AssignMemberAction.php");

	$action = new AssignMemberAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="workshops-sheet">
	<?php
		for ($i=1; $i < 4; $i++) { 
			
			?>
			<div>
				<h2><?= $action->titles[$i]?></h2>
				
				<ul class='droppable workshop-boxes' id=<?= $i ?>>
				
				<?php
						foreach ($action->workshops_deployed as $workshop)
						{
							foreach ($action->member_workshops as $famWork)
							{
								if($famWork["id_workshop"] == $workshop["id"] && $famWork["id_statut"] == $i )
								{
									?>
										<li class="workshop-object draggable" id="<?= $workshop["id"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["name"] ?></h5></li>
									<?php
								}
							}
							if($i == 1 && !array_key_exists($workshop['id'],$action->member_workshops))
							{
								?>
									<li class="workshop-object draggable" id="<?= $workshop["id"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["name"] ?></h5></li>
								<?php
							}


						}
					?>
				</ul>
			</div>

			<?php
		}
	?>
	</div>
	<a id="manage-btn" href="manage-member.php"><?= $action->trans->read("all_pages","back") ?></a>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");