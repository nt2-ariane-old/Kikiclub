<?php
	require_once("action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once("partial/header.php");
?>
	<link rel="stylesheet" href="css/console.css">
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
						<textarea name="content" id="editor" cols="50" rows="10" style="width:80%;"></textarea>
						<button type="submit" name="push">Add</button>
						<select name="difficulty">
							<option value="0">Easy</option>
							<option value="1">Intermediate</option>
							<option value="2">Hard</option>
						</select>
						<button type="submit" name="back">Back</button>
					</form>
				</div>

				<?php
			}
			else if($action->modify)
			{

			}
			else
			{
				?>
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
				<?php
			}

		?>

	</div>

	<div id="users" class="tabcontent">

	</div>
<?php
	require_once("partial/footer.php");