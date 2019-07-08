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
		<?php
			if($actionUser->create)
			{
				//loadProfil(null,$actionUser);
				?>
					<div class="users-footer">
						<a class="manage-btn" href="users.php"><?= $action->trans->read("users","return") ?></a>
					</div>
				<?php
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
						<?php
							loadProfil($actionUser->family_member,$actionUser);
						?>
					</div>
					<div class="users-footer">
						<a class="manage-btn" href="users.php"><?= $action->trans->read("users","return") ?></a>
					</div>

				<?php
			}
			else
			{
				?>
				<div id="family-carousel" class="carousel slide" data-ride="carousel">
					<!-- Content -->
					<div class="carousel-inner" id="family">
						<script>loadChildren()</script>
				   	</div>
				   	<!-- Controls -->
				   	<a class="carousel-control-prev" href="#family-carousel" role="button" data-slide="prev">
				     	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				     	<span class="sr-only">Previous</span>
				   	</a>
				   	<a class="carousel-control-next" href="#family-carousel" role="button" data-slide="next">
				    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
				     	<span class="sr-only">Next</span>
				   	</a>
				</div>

				<div class="users-footer">
					<a class="manage-btn" onclick="loadChildren()"><?= $action->trans->read("users","manage") ?></a>
				</div>

				<?php
			}
		?>