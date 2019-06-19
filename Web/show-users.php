<?php
	require_once("action/ShowUsersAction.php");

	$actionUser = new ShowUsersAction();
	$actionUser->execute();
?>
	<link rel="stylesheet" href="./css/users.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/users-mobile.css" type="text/css" media="handheld" />

	<script src="javascript/users.js"></script>

	<template id="child-template">
		<div class='child-info'>

			<a href="#"><div class='child-logo'></div><div class='child-stateLogo'></div></a>

			<h2 class='child-name'></h2>
			<h2 class='child-age'></h2>
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

					<div class="register-contents">
					<?php
						if($actionUser->error)
						{
							?>
								<div class="error"><?= $actionUser->errorMsg?></div>
							<?php
						}
					?>

					<div class="tab">
						<button class="tablinks" onclick="openTab(event, 'profil')">Profil</button>
						<button class="tablinks" onclick="openTab(event, 'stats')">Statistiques</button>
						<button class="tablinks" onclick="openTab(event, 'workshops')">Workshops</button>
					</div>
					<div id="profil" class="tabcontent">
						<h2>Profil</h2>
						<?php
							loadProfil($actionUser->family_member,$actionUser);
						?>
					</div>


					<div id="stats" class="tabcontent">
						<h2>Statistiques</h2>
					</div>

					<div id="workshops" class="tabcontent">
						<h2>Workshops</h2>
					</div>
					<div id="manage-btn"><a href="?usermode=normal">Return to Profiles</a></div>

				<?php
			}
			else
			{

				?>
				<div id="family">
					<script>loadChildren()</script>
				</div>


				<div id="manage-btn" onclick="loadChildren()">Manage Profiles</div>


				<?php
			}
		?>