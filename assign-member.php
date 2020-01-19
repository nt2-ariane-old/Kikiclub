<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/AssignMemberAction.php");

	$action = new AssignMemberAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="workshops-sheet">
	<?php
<<<<<<< HEAD
		for ($i=1; $i < 4; $i++) {

			?>
			<div>
				<h2><?= $action->titles[$i]?></h2>

				<ul class='droppable workshop-boxes' id='box-<?= $i?>'>
=======
		for ($i=1; $i < 4; $i++) { 
			
			?>
			<div>
				<h2><?= $action->titles[$i]?></h2>
				
				<ul class='droppable workshop-boxes' id=<?= $i ?>>
				
>>>>>>> 6adc56d24667d7ecdfcf4cb4ce880232e9776d9b
				<?php
						foreach ($action->workshops_deployed as $workshop)
						{
							foreach ($action->member_workshops as $famWork)
							{
								if($famWork["id_workshop"] == $workshop["id"] && $famWork["id_statut"] == $i )
								{
									?>
<<<<<<< HEAD
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

=======
										<li class="workshop-object" id="<?= $workshop["id"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["name"] ?></h5></li>
									<?php
								}
							}
							
>>>>>>> 6adc56d24667d7ecdfcf4cb4ce880232e9776d9b
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