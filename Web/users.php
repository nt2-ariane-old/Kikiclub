<?php
	require_once("action/UsersAction.php");

	$action = new UsersAction();
	$action->execute();

	require_once("partial/header.php");
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
			if($action->create)
			{

				?>
					<div class="register-contents">
					<?php
						if($action->error)
						{
							?>
								<div class="error"><?= $action->errorMsg?></div>
							<?php
						}
					?><form action="users.php" method="post">
					<input type="hidden" name="form" value="create">

					<input type="text" name="firstname" id="firstname" placeholder="First Name">
					<input type="text" name="lastname" id="lasttname" placeholder="Last Name">
					<input type="text" name="birth" id="datepicker" placeholder="Birthday">
					<select name="gender" id="">
						<option value="0">Male</option>
						<option value="1">Female</option>
						<option value="2">Other</option>
						<option value="3">Do not specify</option>
					</select>

					<p>Select Avatar :</p>
					<div class="avatars-list">
						<?php
							foreach( $action->avatars as $avatar)
							{
								?>
								<label>
									<input type="radio" name="avatar" value="<?=$avatar["ID"]?>">
									<img src="<?=$avatar["PATH"]?>">
								</label>

								<?php
							}
						?>
					</div>

					<div class="forms-btns">
						<button type="submit" class="submit-btn">Update</button>
					</div>
				</form>
					<button class="delete-btn" onclick="location.href='?mode=normal';" >Go Back</button>
				<?php
			}
			else if($action->manage)
			{
				?>
				<div id="family">
					<div class='child-info' >
						<a href="?mode=create"><div class='child-logo' id="addLogo"></div></a>
						<h2 class='child-name'>Add Family Member</h2>
					</div>
				</div>
				<div id="manage-btn"><a href="?mode=normal">Return to Profiles</a></div>

					<script>loadChildren("manage")</script>
				<?php

			}
			else if($action->modify)
			{
				?>
<div class="register-contents">
					<?php
						if($action->error)
						{
							?>
								<div class="error"><?= $action->errorMsg?></div>
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
						<form action="users.php" method="post">
						<input type="hidden" name="form" value="create">

						<input type="text" name="firstname" id="firstname" placeholder="First Name" value=<?= $action->family_member["firstname"]  ?>>
						<input type="text" name="lastname" id="lasttname" placeholder="Last Name"  value=<?= $action->family_member["lastname"]  ?>>
						<input type="text" name="birth" id="datepicker" placeholder="Birthday"  value=<?= $action->family_member["birthday"]  ?>>
						<select name="gender" id="">
							<option <?php if($action->family_member["gender_id"] == 0) echo 'selected' ;?> value="0">Male</option>
							<option <?php if($action->family_member["gender_id"] == 1) echo 'selected' ;?> value="1">Female</option>
							<option <?php if($action->family_member["gender_id"] == 2) echo 'selected' ;?> value="2">Other</option>
							<option <?php if($action->family_member["gender_id"] == 3) echo 'selected' ; ?>  value="3">Do not specify</option>
						</select>

						<p>Select Avatar :</p>
						<div class="avatars-list">
							<?php
								foreach( $action->avatars as $avatar)
								{
									?>
									<label>
										<?php
											if($action->family_member["id_avatar"] ==  $avatar["ID"]){
												?>
													<input type="radio" name="avatar" value="<?=$avatar["ID"]?>" checked>

												<?php
											}
											else
											{
												?>
													<input type="radio" name="avatar" value="<?=$avatar["ID"]?>">

												<?php
											}
										?>
										<img src="<?=$avatar["PATH"]?>">
									</label>

									<?php
								}
							?>
						</div>
						<div class="forms-btns">
							<button type="submit" class="submit-btn">Update</button>
						</div>
					</form>
					<button class="delete-btn" onclick="location.href='?delete=true';">Delete</button>
					</div>


					<div id="stats" class="tabcontent">
						<h2>Statistiques</h2>
					</div>

					<div id="workshops" class="tabcontent">
						<h2>Workshops</h2>
					</div>
					<div id="manage-btn"><a href="?mode=normal">Return to Profiles</a></div>

				<?php
			}
			else
			{

				?>
				<div id="family">

					<script>loadChildren()</script>

				</div>

				<div id="manage-btn"><a href="?mode=manage">Manage Profiles</a></div>


				<?php
			}
		?>


	</main>
<?php
	require_once("partial/footer.php");