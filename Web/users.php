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
					?>
					<form action="users.php" method="post">
						<input type="hidden" name="form" value="create">
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


						<input type="text" name="firstname" id="firstname" placeholder="First Name">
						<input type="text" name="lastname" id="lasttname" placeholder="Last Name">
						<p>Birthday: <input type="text" name="birth" id="datepicker"></p>
						<select name="gender" id="">
							<option value="0">Male</option>
							<option value="1">Female</option>
							<option value="2">Other</option>
							<option value="3">Do not specify</option>
						</select>
						<button type="submit">Create</button>
					</form>
					</div>
					<div id="manage-btn"><a href="?mode=normal">Return to Profiles</a></div>

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
					<form action="users.php" method="post">
						<input type="hidden" name="form" value="modify">
							<div class="avatars-list">
							<?php
								foreach( $action->avatars as $avatar)
								{
									?>
									<label>
										<?php
											if($avatar["ID"] == $action->family_member["id_avatar"])
											{
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


						<input type="text" name="firstname" id="firstname" placeholder="First Name" value=<?= $action->family_member["firstname"]  ?>>
						<input type="text" name="lastname" id="lasttname" placeholder="Last Name" value=<?= $action->family_member["lastname"]  ?>>
						<p>Birthday: <input type="text" name="birth" id="datepicker" value=<?= $action->family_member["birthday"]  ?>></p>
						<select name="gender" id="">
							<option value="0" <?php if ($action->family_member["gender_id"] == 0 ) echo 'selected' ; ?>>Male</option>
							<option value="1" <?php if ($action->family_member["gender_id"] == 1 ) echo 'selected' ; ?>>Female</option>
							<option value="2" <?php if ($action->family_member["gender_id"] == 2 ) echo 'selected' ; ?>>Other</option>
							<option value="3" <?php if ($action->family_member["gender_id"] == 3 ) echo 'selected' ; ?>>Do not specify</option>
						</select>
						<button type="submit">Update</button>
						<a href="?delete=true"> delete </a>
					</form>
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