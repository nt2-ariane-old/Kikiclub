<?php
	require_once("action/ShowUsersAction.php");

	$actionUser = new ShowUsersAction();
	$actionUser->trans = $action->trans;
	$actionUser->execute();
?>

	<template id="child-template">
		<div class='child-info'>

			<a href="#"><div class='child-logo'></div><div class='child-stateLogo'></div></a>

			<h2 class='child-name'></h2>
			<p class='child-nbWorkshops'></p>
			<p class='child-nbPTS'></p>
			<div class='child-nbalert'></div>
			<a href="#"><div class='x-button'></div></a>


		</div>
	</template>

	<main>
		<?php
			if($actionUser->create)
			{
				loadProfil(null,$actionUser);
			}
			else if($actionUser->modify)
			{
				?>


					<?php
						if($actionUser->error)
						{
							?>
								<div class="error"><?= $actionUser->errorMsg?></div>
							<?php
						}
					?>

					<div id="profil">
						<h2><?= $action->trans->read("users","profil") ?></h2>
						<?php
							loadProfil($actionUser->family_member,$actionUser);
						?>
					</div>

					<div id="manage-btn" class="users-page"><a onclick="post('users.php',{'usermode':'manage'})"><?= $action->trans->read("users","return") ?></a></div>

				<?php
			}
			else
			{

				?>
				<div id="family">
					<script>loadChildren()</script>
				</div>

				<div class="manage-btn" onclick="loadChildren()"><?= $action->trans->read("users","manage") ?></div>

				<?php
			}
		?>