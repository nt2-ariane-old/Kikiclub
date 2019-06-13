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
		<button class="tablinks" onclick="openTab(event, 'workshops')">Workshops</button>
		<button class="tablinks" onclick="openTab(event, 'users')">Users</button>
	</div>

	<div id="workshops" class="tabcontent <?php if($action->pageWorkshops) echo "selected" ?>">
		<h2>Workshops Management</h2>

		<?php
			if($action->add)
			{
				?>
				<div class="form-workshops">
					<form action="console.php" method="post"  enctype="multipart/form-data">
						<input type="hidden" name="add">
						<input type="hidden" name="workshops">
						<input type="text" name="name" placeholder="Title">
						<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onKeyDown="limitText(this.form.content,125);" onKeyUp="limitText(this.form.content,125);"></textarea>
						(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">125</div> left.
						<select name="difficulty">
							<option value="0">Easy</option>
							<option value="1">Intermediate</option>
							<option value="2">Hard</option>
						</select>

						Choose Workshop Image: <input name="workshopFile" type="file" /><br />

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
					<form action="console.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="modify">
						<input type="hidden" name="workshops">

						<input type="hidden" name="workshops_list[]" value="<?=$action->workshopMod["ID"]?>"></td>

						<input type="text" name="name" placeholder="Title" value="<?= $action->workshopMod["NAME"]  ?>">
						<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onKeyDown="limitText(this.form.content,125);" onKeyUp="limitText(this.form.content,125);"><?= $action->workshopMod["CONTENT"]?></textarea>
						(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">125</div> left.

						<select name="difficulty">
							<option value="0" <?php if($action->workshopMod["DIFFICULTY"] == 0) echo 'selected' ;?>>Easy</option>
							<option value="1" <?php if($action->workshopMod["DIFFICULTY"] == 1) echo 'selected' ;?>>Intermediate</option>
							<option value="2" <?php if($action->workshopMod["DIFFICULTY"] == 2) echo 'selected' ;?>>Hard</option>
						</select>

						<div id="questions">
							<input type="hidden" name="nbQuestions" value=0 id="nbQuestions">
						</div>
						<a onclick="addquestion()">Add Question</a>


						<!-- <input type="hidden" name="MAX_FILE_SIZE" value="100000" /> -->
						Choose Workshop Image: <input name="workshopFile" type="file" /><br />

						<button type="submit" name="push">Modify</button>
						<button type="submit" name="back">Back</button>
					</form>
				</div>
				<?php
			}
			else
			{
				?>
				<div class='form-workshops'>

					<form action="console.php" method="post">
					<input type="hidden" name="workshops">

					<table style="width:100%" id="workshops-table">
					<tr>
						<th >Select</th>
						<th>Image</th>
						<th onclick="sortingTable('workshops-table',2)">Name</th>
						<th onclick="sortingTable('workshops-table',3)">Content</th>
						<th onclick="sortingTable('workshops-table',4)">Difficulty</th>
					</tr>
						<?php
							foreach($action->workshops as $workshop)
							{
								?>
									<tr>
										<td><input type="checkbox" name="workshops_list[]" value="<?=$workshop["ID"]?>"></td>
										<td><?php
											if($workshop["MEDIA_TYPE"] == "mp4")
											{
												?>
													<video width="100" height="100" controls>
														<source src="<?= $workshop["MEDIA_PATH"] ?>" type="video/<?= $workshop["MEDIA_TYPE"] ?>">
														Your browser does not support the video tag.
													</video>
												<?php
											} else if ($workshop["MEDIA_TYPE"] == "png" ||
														$workshop["MEDIA_TYPE"] == "jpg")
														{
															?>
															<img style="width:100px;" src=<?=$workshop["MEDIA_PATH"]?> alt="">
															<?php
														}
											else if($workshop["MEDIA_TYPE"] == "mp3")
											{
												?>
												<audio src="<?=$workshop["MEDIA_PATH"]?>" controls="controls">
													Your browser does not support the audio element.
												</audio>
												<?php
											}
										?></td>
										<td><h5><?=$workshop["NAME"]?></h5></td>
										<td><p><?=$workshop["CONTENT"]?></p></td>
										<td><?=$workshop["DIFFICULTY"]?></td>
									</tr>
								<?php
							}
						?>
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
							<tbody>
							<?php
								foreach($action->users as $user)
								{
							?>
								<tr>
									<td><input type="checkbox" name="users_list[]" value="<?=$user["USER"]["ID"]?>"></td>
									<td><?=$user["USER"]["ID"]?></td>
									<td><?=$user["USER"]["FIRSTNAME"]?></td>
									<td><?=$user["USER"]["LASTNAME"]?></td>
									<td><?=$user["USER"]["EMAIL"]?></td>
									<td>
									<?php
										if(sizeof($user["FAMILY"]) > 0){
									?>
									<table style="width:100%" class="memberTable">
										<thead>
										<tr >
											<th style="width:5%;">Select</th>
											<th style="width:10%;">ID</th>
											<th style="width:25%;">First Name</th>
											<th style="width:25%;">Last Name</th>
											<th style="width:25%;">Birthday</th>
											<th style="width:10%;">Score</th>

										</tr>
										</thead>

										<tbody>
										<?php
											foreach($user["FAMILY"] as $member)
											{
										?>
											<tr>

												<td><input type="checkbox" name="members_list[]" value="<?=$member["ID"]?>"></td>
												<td><?=$member["ID"]?></td>
												<td><?=$member["FIRSTNAME"]?></td>
												<td><?=$member["LASTNAME"]?></td>
												<td><?=$member["BIRTHDAY"]?></td>
												<td><?=$member["SCORE"]?></td>
											</tr>
										<?php
											}
										?>
										</table>
										<?php
											}
										?>
									</td>
									</tbody>
								</tr>
							<?php
								}
							?>
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