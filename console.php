<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
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

						if($action->add)
						{
							?>
								<div class="management-tab">
									<div class="sheet">
										<?php
										loadWorkshopsCreator(null,$action);
										?>
									</div>
								</div>
							<?php
						}
						else if($action->update)
						{
							?>
								<div class="management-tab">

								</div>
							<?php
						}
						else
						{
							?>

							<div class="sheet">

								<div class="bar">
									<input type="text" name="search" id="search-bar" placeholder="Search" onkeyup="searchWorkshop()">
								</div>
								<div class='form-workshops'>

									<form action="console.php" method="post" onSubmit="return validTab(this)">
									<input type="hidden" name="workshops">

									<table class='table table-striped table-hover' style="width:100%">
										<thead>
											<tr>
												<th onclick="checkAll()" >Select</th>
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
											<button type="submit" class="submit-btn" name="add" onclick="clicked=this.name" value="true">Add</button>
											<button type="submit" class="submit-btn" name="update" onclick="clicked=this.name" value="true">Update</button>
											<button type="submit" class="submit-btn" name="deployed" onclick="clicked=this.name" value="true">Deployed</button>
											<button type="submit" class="delete-btn"name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement.parentElement,{type:'form'});" value="true">Delete</button>
										</div>
									</div>

								</form>
								</div>
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


						if($action->modFamily)
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
			else if($action->update)
			{
				?>
				<div class="management-tab">
					<div class="sheet">
						<form id="profil-form" action="console.php" method="post">

							<input type="hidden" name="update">
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
							<button type="submit" name="push" onclick="clicked=this.name">Apply</button>
							<button type="submit" name="back" onclick="clicked=this.name">Back</button>
						</form>
					</div>
				</div>
				<?php
			}
			else
			{
			?>
				<div class='sheet'>
					<div class="bar">
						<input type="text" name="search" id="search-barRobots" placeholder="search" onkeyup="searchWorkshop()">
					</div>

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
									<button type="submit" class="submit-btn" name="add" onclick="clicked=this.name" value="true">Add</button>
									<button type="submit" class="submit-btn"name="update" onclick="clicked=this.name" value="true">Update</button>
									<button type="submit" class="delete-btn"name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement.parentElement,{type:'form'});" value="true">Delete</button>
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
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");