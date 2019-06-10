<?php
	require_once("action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once("partial/header.php");
?>
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
					<form action="console.php" method="post">
						<input type="hidden" name="add">
						<input type="text" name="name" placeholder="Title">
						<textarea name="content" id="" cols="50" rows="10" style="width:80%;"></textarea>
						<button type="submit" name="push">Add</button>
						<button onclick="window.location.href='?mode=normal'">Back</button>
					</form>
				<?php
			}
			else if($action->modify)
			{

			}
			else
			{
				?>
					<form action="console.php" method="post">
						<?php
							foreach($action->workshops as $workshop)
							{
								?>
									<div class="workshop-line">
										<input type="checkbox" name="workshop_id" value="<?=$workshop["ID"]?>">
										<img src=<?=$workshop["IMAGE_PATH"]?> alt="">
										<h5><?=$workshop["NAME"]?></h5>
										<p><?=$workshop["CONTENT"]?></p>
									</div>
								<?php
							}
						?>
						<button type="submit" name="add">Add</button>
						<button type="submit" name="modify">Modify</button>
						<button type="submit" name="delete">Delete</button>
					</form>
				<?php
			}

		?>

	</div>

	<div id="users" class="tabcontent">

	</div>
<?php
	require_once("partial/footer.php");