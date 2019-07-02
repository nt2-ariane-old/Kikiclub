<?php
	require_once("action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once("partial/header.php");
?>


	<?php
		if($action->error)
		{
			?>
				<div class="error"><?= $action->errorMsg?></div>
			<?php
		}
	?>

	<button onclick="">Send Email</button>
	<?php if($action->pageWorkshops)
		{
			?>
				<div class="management-tab">

					<?php
						if($action->workshopAdded)
						{
							?>
								<script>sendEmail( <?= json_encode($action->workshopMod) ?> )</script>
							<?php
						}
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
							<div class="bar">
								<input type="text" name="research" id="research-bar" placeholder="Research" onkeyup="researchWorkshop()">
							</div>
							<div class='form-workshops'>

								<form action="console.php" method="post" onSubmit="return validTab(this)">
								<input type="hidden" name="workshops">

								<table class='table table-striped table-hover' style="width:100%">
									<thead>
										<tr>
											<th >Select</th>
											<th>Image</th>
											<th onclick="sortingTable('workshops-table',2)">Name</th>
											<th onclick="sortingTable('workshops-table',3)">Content</th>
											<th onclick="sortingTable('workshops-table',4)"><?= $action->trans->read('workshops','difficulty') ?></th>
											<th onclick="sortingTable('workshops-table',5)">Robot</th>
										</tr>
									</thead>
									<tbody class='tableValue'>

										<script>researchWorkshop()</script>
									</tbody>
								</table>
									<button type="submit" name="add" onclick="clicked=this.name" value="true">Add</button>
									<button type="submit" name="modify" onclick="clicked=this.name" value="true">Modify</button>
									<button type="submit" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement);" value="true">Delete</button>
								</form>
							</div>
							<?php
						}
					?>
				</div>
			<?php
		}
		else if($action->pageUsers)
		{
			?>
				<div class="management-tab">

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

									<button type="submit" name="push" onclick="clicked=this.name">Add</button>
									<button type="submit" name="back" onclick="clicked=this.name">Back</button>
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

									<button type="submit" name="push" onclick="clicked=this.name">Modify</button>
									<button type="submit" name="back" onclick="clicked=this.name">Back</button>
								</form>
							</div>
							<?php
						}
						else if ($action->assignFamily)
						{
							?>
								<ul id="new" class="droppable Workshop-boxes">

								<?php
										foreach ($action->workshops as $workshop) {
											$valide = true;
											foreach ($action->familyWorkshops as $famWork) {
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] )
												{
													if($famWork["STATUT"] != 1)
													{
														$valide = false;
													}

												}
											}
											if($valide == true)
											{

												?>
														<div class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></div>
												<?php
											}
										}
									?>
								</ul>

								<ul id="not-started" class="droppable Workshop-boxes">

									<?php
										foreach ($action->workshops as $workshop) {
											foreach ($action->familyWorkshops as $famWork) {
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["STATUT"] == 2 )
												{
													?>
														<li class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></li>
													<?php
												}
											}
										}
									?>
								</ul>

								<ul id="in-progress" class="droppable Workshop-boxes">

									<?php
										foreach ($action->workshops as $workshop) {
											foreach ($action->familyWorkshops as $famWork) {
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["STATUT"] == 3 )
												{
													?>
														<li class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></li>
													<?php
												}
											}
										}
									?>
								</ul>

								<ul id="complete" class="droppable Workshop-boxes">
									<?php
										foreach ($action->workshops as $workshop) {
											foreach ($action->familyWorkshops as $famWork) {
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["STATUT"] == 4 )
												{
													?>
														<li class="workshop-object" id="<?= $workshop["ID"] ?>"><?php loadMedia($workshop) ?><h5><?= $workshop["NAME"] ?></h5></li>
													<?php
												}
											}
										}
									?>
								</ul>

								<a id="manage-btn" href="console.php">Back</a>
							<?php
						}
						else if($action->modFamily)
						{
							loadProfil($action->familyMod,$action);
							?>
								<a id="manage-btn" href="console.php">Back</a>
							<?php
						}
						else if($action->addFamily)
						{
							loadProfil(null,$action);
							?>
							<a id="manage-btn" href="console.php">Back</a>
						<?php
						}
						else
						{
							?>
							<div class="bar">
								<input type="text" name="research" id="research-barUsers" placeholder="Research" onkeyup="researchMember()">
							</div>
							<div class='form-workshops'>
								<form action="console.php" method="post" onSubmit="return validTab(this)">
									<input type="hidden" name="users">
									<table  class='table table-striped table-hover' style="width:100%" id="usersTable">
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

									<button type="submit" name="assign" onclick="clicked=this.name">Assign Workshop to family member</button>
									<button type="submit" name="add" onclick="clicked=this.name">Add Users</button>
									<button type="submit" name="addFamily" onclick="clicked=this.name">Add Family Member</button>
									<button type="submit" name="modify" onclick="clicked=this.name">Modify</button>
									<button type="submit" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement)">Delete</button>
								</form>
							</div>
						<?php
						}
						?>
				</div>
			<?php
		}
		else if($action->pageRobots)
		{
			if($action->add)
			{
				?>
				<div class="form-workshops">
					<form action="console.php" method="post">
						<input type="hidden" name="add">
						<input type="hidden" name="robots">

						<input type="text" name="name" placeholder="Name">

						<p> <span class="input_name"> Age Recommanded :</span>
						<select name="grade_recommanded">
							<?php
								foreach ($action->grades as $grade) {
									?>
										<option value="<?= $grade["ID"]?>"><?= $grade["NAME"]?></option>
									<?php
								}
							?>

						</select>
						</p>

						<?php
							foreach ($action->difficulties as $difficulty) {
								?>
									<p><span class="input_name"><?= $difficulty["NAME"]?></span><input type="number" name="score_<?= $difficulty["ID"]?>" placeholder="Score"></p>
								<?php
							}
						?>
						<button type="submit" name="push" onclick="clicked=this.name">Add</button>
						<button type="submit" name="back" onclick="clicked=this.name">Back</button>
					</form>
				</div>
				<?php
			}
			else if($action->modify)
			{
				?>
				<div class="form-workshops">
					<form action="console.php" method="post">
						<?php
							var_dump($action->robotMod);
						?>
						<input type="hidden" name="modify">
						<input type="hidden" name="robots">
						<input type="hidden" name="robots_list[]" value="<?=$action->robotMod["ROBOTS"]["ID"]?>"></td>


						<input type="text" name="name" placeholder="Name" value="<?=$action->robotMod["ROBOTS"]["NAME"]?>">

						<p> <span class="input_name"> Age Recommanded :</span>
						<select name="grade_recommanded">
							<?php
								foreach ($action->grades as $grade) {
									?>
										<option value="<?= $grade["ID"]?>"><?= $grade["NAME"]?></option>
									<?php
								}
							?>

						</select>
						</p>

						<?php
							foreach ($action->robotMod["SCORES"] as $score) {
								?>
									<p><span class="input_name"><?= $score["DIFFICULTY"]?></span><input type="number" name="score_<?= $score["ID_DIFFICULTY"]?>" placeholder="Score" value="<?= $score["SCORE"]?>"></p>
								<?php
							}
						?>
						<button type="submit" name="push" onclick="clicked=this.name">Modify</button>
						<button type="submit" name="back" onclick="clicked=this.name">Back</button>
					</form>
				</div>
				<?php
			}
			else
			{
			?>
				<div class="management-tab">
					<div class="bar">
						<input type="text" name="research" id="research-barRobots" placeholder="Research" onkeyup="researchWorkshop()">
					</div>
					<div class='form-workshops'>
						<form action="console.php" method="post" onSubmit="return validTab(this)">
							<input type="hidden" name="robots">

							<table class='table table-striped table-hover' style="width:100%">
								<thead>
									<tr>
										<th >Select</th>
										<th onclick="sortingTable('workshops-table',1)">ID</th>
										<th onclick="sortingTable('workshops-table',2)">Name</th>
										<th>Scores By Difficulties</th>
									</tr>
								</thead>
								<tbody id='table-robots'>
									<script>researchRobots()</script>
								</tbody>
							</table>

							<button type="submit" name="add" onclick="clicked=this.name" value="true">Add</button>
							<button type="submit" name="modify" onclick="clicked=this.name" value="true">Modify</button>
							<button type="submit" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement);" value="true">Delete</button>
						</form>
					</div>
				</div>
			<?php
			}
		}
		?>
<?php
	require_once("partial/footer.php");