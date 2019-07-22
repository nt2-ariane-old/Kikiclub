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


								</form>
								</div>
							</div>
							<?php
						}
					?>
				</div>
			<?php
		}

		?>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");