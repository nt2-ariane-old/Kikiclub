<?php
	require_once("action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<link rel="stylesheet" href="css/console.css">
	<script src="javascript/admin.js"></script>


	<?php
		if($action->error)
		{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
		}
	?>


	<div class="tab">
		<form action="console.php" method="post">
			<button class="tablinks" name="workshops">Workshops</button>
			<button class="tablinks" name="users">Users</button>
		</form>

	</div>

	<div id="workshops" class="tabcontent <?php if($action->pageWorkshops) echo "selected" ?>">
		<h2>Workshops Management</h2>
		<div class="bar">
			<input type="text" name="research" id="research-bar" placeholder="Research" onkeyup="researchWorkshop()">
		</div>
		<?php
			if($action->add)
			{
				loadWorkshopsCreator(null,$action);
			}
			else if($action->modify)
			{
				loadWorkshopsCreator($action->workshopMod,$action);
			}
			else
			{
				?>
				<div class='form-workshops'>

					<form action="console.php" method="post">
					<input type="hidden" name="workshops">

					<table style="width:100%" id="workshops-table">
						<thead>
							<tr>
								<th >Select</th>
								<th>Image</th>
								<th onclick="sortingTable('workshops-table',2)">Name</th>
								<th onclick="sortingTable('workshops-table',3)">Content</th>
								<th onclick="sortingTable('workshops-table',4)">Difficulty</th>
								<th onclick="sortingTable('workshops-table',5)">Robot</th>
							</tr>
						</thead>
						<tbody class='tableValue'>

							<script>researchWorkshop()</script>
						</tbody>
					</table>
						<button type="submit" name="add" value="true">Add</button>
						<button type="submit" name="modify" value="true">Modify</button>
						<button type="submit" name="delete" value="true">Delete</button>
					</form>
				</div>
				<?php
			}

		?>

	</div>

	<div id="users" class="tabcontent <?php if($action->pageUsers) echo "selected" ?>" >
		<h2>Users Management</h2>
		<div class="bar">
			<input type="text" name="research" id="research-barUsers" placeholder="Research" onkeyup="researchMember()">
		</div>
		<?php
			if($action->add)
			{
				?>
				<div class="form-workshops">
					<form action="console.php" method="post">
						<input type="hidden" name="add">
						<input type="hidden" name="users">

						<input type="text" name="firstname" placeholder="First Name">
						<input type="text" name="lastname" placeholder="Last Name">
						<input type="text" name="email" placeholder="Email">

						<button type="submit" name="push">Add</button>
						<button type="submit" name="back">Back</button>
					</form>
				</div>

				<?php
			}
			else if($action->modify)
			{

				?>
				<div class="form-workshops">
					<form action="console.php" method="post">
						<input type="hidden" name="modify">
						<input type="hidden" name="users">
						<input type="hidden" name="users_list[]" value="<?=$action->userMod["ID"]?>"></td>


						<input type="text" name="firstname" placeholder="First Name" value="<?= $action->userMod["FIRSTNAME"] ?>">
						<input type="text" name="lastname" placeholder="Last Name" value="<?= $action->userMod["LASTNAME"] ?>">
						<input type="text" name="email" placeholder="Email" value="<?= $action->userMod["EMAIL"] ?>">

						<button type="submit" name="push">Modify</button>
						<button type="submit" name="back">Back</button>
					</form>
				</div>
				<?php
			}
			else if ($action->assignFamily)
			{
				?>
					<div id="workshops-list">
					<h2>Non assigné</h2>
					<?php
							foreach ($action->workshops as $workshop) {
								$valide = true;
								foreach ($action->familyWorkshops as $famWork) {
									if($famWork["ID_WORKSHOP"] == $workshop["ID"] )
									{
										$valide = false;

									}
								}
								if($valide == true)
								{

									?>
										<div class="workshop-object" id="<?= $workshop["ID"] ?>"><?= $workshop["NAME"] ?></div>
									<?php
								}
							}
						?>
					</div>

					<div id="in-progress" class="droppable">
					<h2>In Progress</h2>

						<?php
							foreach ($action->workshops as $workshop) {
								foreach ($action->familyWorkshops as $famWork) {
									if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["STATUT"] == 1 )
									{
										?>
											<div class="workshop-object" id="<?= $workshop["ID"] ?>"><?= $workshop["NAME"] ?></div>

										<?php
									}
								}
								?>
								<?php
							}
						?>
					</div>
					<div id="not-started" class="droppable">
					<h2>Not Started</h2>

					<?php
							foreach ($action->workshops as $workshop) {
								foreach ($action->familyWorkshops as $famWork) {
									if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["STATUT"] == 0 )
									{
										?>
											<div class="workshop-object" id="<?= $workshop["ID"] ?>"><?= $workshop["NAME"] ?></div>

										<?php
									}
								}
							}
						?>
					</div>
					<div id="complete" class="droppable">
					<h2>Complete</h2>

						<?php
							foreach ($action->workshops as $workshop) {
								foreach ($action->familyWorkshops as $famWork) {
									if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["STATUT"] == 2 )
									{
										?>
											<div class="workshop-object" id="<?= $workshop["ID"] ?>"><?= $workshop["NAME"] ?></div>

										<?php
									}
								}
								?>
								<?php
							}
						?>
					</div>
					<a id="manage-btn" onclick="sendWorkshopState()">Send</a>
				<?php
			}
			else if($action->modFamily)
			{
				loadProfil($action->familyMod,$action);
			}
			else if($action->addFamily)
			{
				loadProfil(null,$action);
			}
			else
			{
				?>
				<div class='form-workshops'>
					<form action="console.php" method="post">
						<input type="hidden" name="users">
						<table style="width:100%" class="usersTable">
							<thead>
							<tr class="rowMember">
								<th style="width:5%;">Select</th>
								<th style="width:10%;">ID</th>
								<th style="width:10%;">First Name</th>
								<th style="width:10%;">Last Name</th>
								<th style="width:15%;">Email</th>
								<th style="width:50%;">Family</th>
							</tr>
							</thead>
							<tbody id="table-users">
								<script>researchMember()</script>
							</tbody>
						</table>

						<button type="submit" name="assign" value="true">Assign Workshop to family member</button>
						<button type="submit" name="add" value="true">Add Users</button>
						<button type="submit" name="addFamily" value="true">Add Family Member</button>
						<button type="submit" name="modify" value="true">Modify</button>
						<button type="submit" name="delete" value="true">Delete</button>
					</form>
				</div>
			<?php
			}
			?>
	</div>
<?php
	require_once("partial/footer.php");