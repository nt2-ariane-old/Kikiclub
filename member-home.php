<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/MemberHomeAction.php");

	$action = new MemberHomeAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
	
			<h3><?= $action->trans->read("member-home","new-workshops") ?></h3>
			<?php
			if(!array_key_exists('< Mes nouveaux défis >',$action->workshops_categories))
			{
				?>
					<p><?= $action->trans->read("member-home","no-new") ?></p>
					<?php
			}
			else
			{
				loadMemberWorkshops($action->workshops_categories['< Mes nouveaux défis >'],"new",$action);
			}
			?>
				<h3><?= $action->trans->read("member-home","started-workshops") ?></h3>
			<?php
			if(!array_key_exists('# J\'ai pas eu le temps de terminer!',$action->workshops_categories))
			{
				?>
					<p><?= $action->trans->read("member-home","no-started") ?></p>
				<?php
			}
			else
			{
				loadMemberWorkshops($action->workshops_categories['# J\'ai pas eu le temps de terminer!'],"started",$action);
			}
			?>
				<h3><?= $action->trans->read("member-home","finished-workshops") ?></h3>
			<?php
			if(!array_key_exists('== Yeah! J\'ai réussi ces ateliers!',$action->workshops_categories))
			{
				?>
					<p><?= $action->trans->read("member-home","no-finished") ?></p>
				<?php
			}
			else
			{
				loadMemberWorkshops($action->workshops_categories['== Yeah! J\'ai réussi ces ateliers!'],"finished",$action);
			}
		?>
		<h3><?= $action->trans->read("member-home","badges") ?></h3>
		<?php
			loadBadgesSlider($action->won_badges,$action->all_badges,"badges",$action,"badges",true);
		?>
	</main>
	<div id="member_modal" class="modal">
	  <div id="modal_content" class="modal_content"></div>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");