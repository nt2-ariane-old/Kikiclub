<?php
	require_once("action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<link rel="stylesheet" href="css/console.css">
	<script src="javascript/admin.js"></script>
	<div class="tab">
		<button class="tablinks" onclick="openTab(event, 'workshops')">Workshops</button>
		<button class="tablinks" onclick="openTab(event, 'users')">Users</button>
	</div>

	<div id="workshops" class="tabcontent">
		<h2>Workshops Management</h2>

		<?php
			if($action->add)
			{
				?>
				<div class="form-workshops">
					<form action="console.php" method="post">
						<input type="hidden" name="add">
						<input type="text" name="name" placeholder="Title">
						<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;height:150px;" onKeyDown="limitText(this.form.content,125);" onKeyUp="limitText(this.form.content,125);"></textarea>
						(Maximum characters: 125). You have <div style="display:inline-block;" id="countdown">125</div> left.
						<select name="difficulty">
							<option value="0">Easy</option>
							<option value="1">Intermediate</option>
							<option value="2">Hard</option>
						</select>

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
					<table style="width:100%">
					<tr>
						<th>Select</th>
						<th>Image</th>
						<th>Name</th>
						<th>Content</th>
						<th>Difficulty</th>
					</tr>
						<?php
							foreach($action->workshops as $workshop)
							{
								?>
									<tr>
										<td><input type="checkbox" name="workshops_list[]" value="<?=$workshop["ID"]?>"></td>
										<td><img style="width:100px;" src=<?=$workshop["IMAGE_PATH"]?> alt=""></td>
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

	<div id="users" class="tabcontent">
		<h2>Users Management</h2>
		<div class='form-workshops'>
					<form action="console.php" method="post">
					<table style="width:100%">
					<tr>
						<th>Select</th>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
					</tr>
						<?php
							foreach($action->users as $user)
							{
								?>
									<tr>
										<td><input type="checkbox" name="users_list[]" value="<?=$user["ID"]?>"></td>
										<td><?=$user["ID"]?></td>
										<td><?=$user["FIRSTNAME"]?></td>
										<td><?=$user["LASTNAME"]?></td>
										<td><?=$user["EMAIL"]?></td>
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
	</div>
<?php
	require_once("partial/footer.php");