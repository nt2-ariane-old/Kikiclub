<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/MemberHomeAction.php");

	$action = new MemberHomeAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
		<?php
			$i = 0;
			foreach ($action->workshops_categories as $key => $workshops) {
				?>
				<h3><?= $key ?></h3>
				<div class="container">
					<div class="row line" id="<?= $i ?>">
							<?php
				foreach ($workshops as $workshop) {
					?>
						<div class="col-lg-2">
							<a onclick="openModal();openWorkshop(<?= $workshop['id'] ?>)" ><div class="workshop" >
								<!-- <a href="workshop-infos.php?workshop_id=<?= '..'//$workshop["id"] ?>" ><div class="workshop" > -->
									<?php
									loadMedia($workshop);
								?>
								<h4><?= $workshop["name"] ?></h4>
							</div></a>
						</div>
						<?php
				}
				?>
					</div>
					<?php
						if(sizeof($workshops) > 6)
						{
							?>
								<a  class="link-collapse" onclick="show(<?= $i ?>,this)">Afficher plus</a>
							<?php
						}
					?>
				</div>
				<?php
				$i++;
			}
			if(!array_key_exists('< Mes nouveaux défis >',$action->workshops_categories))
			{
				?>
					<h3>< Mes nouveaux défis ></h3>
					<p>Aucun nouveaux défis...</p>
				<?php
			}
			if(!array_key_exists('# J\'ai pas eu le temps de terminer!',$action->workshops_categories))
			{
				?>
					<h3># J'ai pas eu le temps de terminer!</h3>
					<p>Aucun ateliers non terminés...</p>
				<?php
			}
			if(!array_key_exists('== Yeah! J\'ai réussi ces ateliers!',$action->workshops_categories))
			{
				?>
					<h3>== Yeah! J'ai réussi ces ateliers!</h3>
					<p>Aucun ateliers réussi...</p>
				<?php
			}
		?>
		<h3>__ Badges</h3>
		<?php
			loadBadgesSlider($action->won_badges,$action->all_badges,"badges",$action,"badges",true);
		?>
	</main>
	<div id="member_modal" class="modal">
	  <div id="modal_content" class="modal_content"></div>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");