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

	<?php if($action->pageWorkshops)
		{
			?>
				<div class="management-tab">

					<?php
						if($action->workshopAdded)
						{

							?>
							<div style="background-color:white;color:green;">
								Workshop Added!
							</div>

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
								<input type="text" name="search" id="search-bar" placeholder="Search" onkeyup="searchWorkshop()">
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

										<script>searchWorkshop()</script>
									</tbody>
								</table>
								<div class="control-bar">
									<a data-toggle="collapse" data-target="#controls">Control</a>

									<div class="collapse" id="controls">
										<button type="submit" class="add-btn" name="add" onclick="clicked=this.name" value="true">Add</button>
										<button type="submit" name="modify" onclick="clicked=this.name" value="true">Modify</button>
										<button type="submit" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement);" value="true">Delete</button>
									</div>
								</div>

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
							<div class="sheet">
								<h2>Ajout d'un nouvel Utilisateur</h2>

								<form action="console.php" id="profil-form" method="post">
									<input type="hidden" name="add">
									<input type="hidden" name="users">
									<div class="infos">
										<p><span class="input-title">First Name : </span><input type="text" name="firstname" placeholder="Firstname"></p>
										<p><span class="input-title">Last Name : </span><input type="text" name="lastname" placeholder="Lastname"></p>
										<p><span class="input-title">Email : </span><input type="text" name="email" placeholder="Email"></p>
									</div>
									<div class="forms-btns">
										<button type="submit" class="submit-btn" name="push" onclick="clicked=this.name">Add</button>
										<button type="submit" class="delete-btn" name="back" onclick="clicked=this.name">Back</button>
									</div>

								</form>
							</div>

							<?php
						}
						else if($action->modify)
						{

							?>
							<div class="sheet">
								<h2>Modification de <?= $action->userMod["FIRSTNAME"] ?> </h2>
								<form action="console.php" id="profil-form" method="post">
									<input type="hidden" name="modify">
									<input type="hidden" name="users">
									<input type="hidden" name="users_list[]" value="<?=$action->userMod["ID"]?>"></td>

									<div class="infos">
										<p><span class="input-title">First Name : </span><input type="text" name="firstname" value="<?= $action->userMod["FIRSTNAME"] ?>" placeholder="Firstname"></p>
										<p><span class="input-title">Last Name : </span><input type="text" name="lastname" value="<?= $action->userMod["LASTNAME"] ?>" placeholder="Lastname"></p>
										<p><span class="input-title">Email : </span><input type="text" name="email" value="<?= $action->userMod["EMAIL"] ?>" placeholder="Email"></p>
									</div>
									<div class="forms-btns">
										<button type="submit" class="submit-btn" name="push" onclick="clicked=this.name">Modify</button>
										<button type="submit" class="delete-btn" name="back" onclick="clicked=this.name">Back</button>
									</div>
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
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["ID_STATUT"] == 2 )
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
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["ID_STATUT"] == 3 )
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
												if($famWork["ID_WORKSHOP"] == $workshop["ID"] && $famWork["ID_STATUT"] == 4 )
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
								<div class="autocomplete" style="width:300px;">
									<input id="search-user-firstname" type="text" name="search" onkeyup="searchUsers(this,'firstname')" placeholder="User Firstname">
								</div>
								<div class="autocomplete" style="width:300px;">
									<input id="search-user-lastname" type="text" name="search" onkeyup="searchUsers(this,'lastname')" placeholder="User Lastname">
								</div>
								<div class="autocomplete" style="width:300px;">
									<input id="search-user-email" type="text" name="search" onkeyup="searchUsers(this,'email')" placeholder="User Email">
								</div>

								<div class="autocomplete" style="width:300px;">
									<input id="search-member-firstname" type="text" name="search" onkeyup="searchMember(this,'firstname')" placeholder="Member Firstname">
								</div>

								<div class="autocomplete" style="width:300px;">
									<input id="search-member-lastname" type="text" name="search" onkeyup="searchMember(this,'lastname')" placeholder="Member Lastname">
								</div>

								<div class="autocomplete" style="width:300px;">
									<input id="search-member-email" type="text" name="search" onkeyup="searchMember(this,'firstname')" placeholder="Member Firstname">
								</div>
							</div>

							<?php
								if(!empty($action->users))
								{

									?>


							<div class='form-workshops'>
								<form action="console.php" method="post" onSubmit="return validTab(this)">
									<input type="hidden" name="users">
									<table  class='table table-striped table-hover' style="width:100%" id="usersTable">
										<thead>
										<tr class="rowMember">
											<th style="width:10%;">First Name</th>
											<th style="width:10%;">Last Name</th>
											<th style="width:15%;">Email</th>
											<th style="width:50%;">Family</th>
										</tr>
										</thead>
										<tbody id="table-users">

											<?php
												foreach ($action->users as $user) {
													?>
													<tr>
													<!-- <tr onclick="post('console.php',{'users':null,'users_list[]':<?= $user[0]['USER']['ID'] ?>,'modify':null})"> -->
														<td><?= $user[0]["USER"]["FIRSTNAME"] ?></td>
														<td><?= $user[0]["USER"]["LASTNAME"] ?></td>
														<td><?= $user[0]["USER"]["EMAIL"] ?></td>
														<td>
															<?php
																if(sizeof($user[0]["FAMILY"]) > 0)
																{
																	?>
																	<table>
																		<thead>
																			<tr>
																				<th>Firstname</th>
																				<th>Lastname</th>
																				<th>Score</th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php
																				foreach ($user[0]["FAMILY"] as $member) {
																					?>
																						<tr onclick="post('console.php',{'users':null,'members_list[]':<?= $member['ID'] ?>,'modify':null})">
																							<td><?= $member["FIRSTNAME"] ?></td>
																							<td><?= $member["LASTNAME"] ?></td>
																							<td><?= $member["SCORE"] ?></td>
																						</tr>
																					<?php
																				}
																			?>
																		</tbody>
																	</table>

																	<?php
																}
															?>
														</td>
													</tr></a>
													<?php
												}
											?>
										</tbody>
									</table>
									<div class="control-bar">
										<a data-toggle="collapse" data-target="#controls">Control</a>
										<div id="controls">
											<button type="submit" name="assign" onclick="clicked=this.name">Assign Workshop to family member</button>
											<button type="submit" name="add" onclick="clicked=this.name">Add Users</button>
											<button type="submit" name="addFamily" onclick="clicked=this.name">Add Family Member</button>
											<button type="submit" name="modify" onclick="clicked=this.name">Modify</button>
											<button type="submit" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement)">Delete</button>

										</div>
									</div>
								</form>
							</div>
							<?php
								}
						?>
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
				<div class="sheet">
					<form id="profil-form" action="console.php" method="post">
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
				<div class="sheet">
					<form id="profil-form" action="console.php" method="post">
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
						<input type="text" name="search" id="search-barRobots" placeholder="search" onkeyup="searchWorkshop()">
					</div>
					<div class='sheet'>
						<form action="console.php" id="profil-form" method="post" onSubmit="return validTab(this)">
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
									<script>searchRobots()</script>
								</tbody>
							</table>

							<div class="control-bar">
								<a data-toggle="collapse" data-target="#controls">Control</a>

								<div class="collapse" id="controls">
									<button type="submit" name="add" onclick="clicked=this.name" value="true">Add</button>
									<button type="submit" name="modify" onclick="clicked=this.name" value="true">Modify</button>
									<button type="submit" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement);" value="true">Delete</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php
			}
		}
		?>
<?php
	require_once("partial/footer.php");