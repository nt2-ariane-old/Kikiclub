<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/UsersAction.php");

	$action = new UsersAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	if($action->admin_mode)
	{
		?>
	<div class="sheet">

		<div class="bar">
			<h3>Search Every Feeld</h3>
			<div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-all" type="text" name="search" placeholder="All feelds">
				</div>
			</div>
			<h3>Search User</h3>
			<div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-user-firstname" type="text" name="search" placeholder="User Firstname">
				</div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-user-lastname" type="text" name="search" placeholder="User Lastname">
				</div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-user-email" type="text" name="search" placeholder="User Email">
				</div>
			</div>
			<h3>Search Member</h3>
			<div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-member-firstname" type="text" name="search" onkeyup="searchMember(this,'firstname')" placeholder="Member Firstname">
				</div>

				<div class="autocomplete" style="width:300px;">
					<input id="search-member-lastname" type="text" name="search" onkeyup="searchMember(this,'lastname')" placeholder="Member Lastname">
				</div>
			</div>
		</div>
		<?php
			if(!empty($action->users) || !empty($action->members))
			{
				?>
					<div class='form-workshops'>
						<?php
							if(!empty($action->users))
							{
						?>
							<h2>Users</h2>
							<table  class='table table-striped table-hover' style="width:100%" id="usersTable">
								<thead>
									<tr class="rowMember">
										<th style="width:10%;">First Name</th>
										<th style="width:10%;">Last Name</th>
										<th style="width:15%;">Email</th>
									</tr>
								</thead>
								<tbody id="table-users">
									<?php
										foreach ($action->users as $user) {
									?>
										<tr onclick="change_page('manage-user.php',{'user_id':<?= $user['id'] ?>,'users_action':'update'})">
											<td><?= $user["firstname"] ?></td>
											<td><?= $user["lastname"] ?></td>
											<td><?= $user["email"] ?></td>
										</tr></a>
									<?php
										}
									?>
								</tbody>
							</table>
						<?php
							}
							if (!empty($action->members))
							{
						?>
							<h2>Family's Members</h2>
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
										foreach ($action->members as $member) {
									?>
										<tr onclick="change_page('manage-member.php',{'member_id':<?= $member['id'] ?>,'members_action':'update'})">
											<td><?= $member["firstname"] ?></td>
											<td><?= $member["lastname"] ?></td>
											<td><?= $member["score"] ?></td>
										</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						<?php
							}
						?>

				</div>
			<?php
			}
		?>
	</div>

	<div class="control-bar">
		<a data-toggle="collapse" data-target="#controls">Control</a>
		<div class="collapse" id="controls">
			<button class="submit-btn" onclick="change_page('manage-user.php',{'users_action':'create'})">Add New User</button>
			<!-- <button type="submit" class="delete-btn" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement.parentElement,{type:'form'})">Delete</button> -->
		</div>
	</div>
	<?php
		}
		else
		{

			//show profiles
			?>
	<template id="child-template">
		<div class='child-info'>
			<button href="#"><div class='child-logo'></div><div class='child-stateLogo'></div></button>
			<h2 class='child-name'></h2>
			<p class='child-nbWorkshops'></p>
			<p class='child-nbPTS'></p>
			<div class='child-nbalert'></div>
		</div>
	</template>
	<?php

if($action->detect->isMobile())
{
	?>
				<div id="family">
					<script>loadChildren(false)</script>
				</div>
			<?php
		}
		else
		{
			?>
				<div id="family-carousel" class="carousel slide" data-interval="false" data-ride="carousel">
					<!-- Content -->
					<div class="carousel-inner" id="family">
						<script>loadChildren(true)</script>
					</div>

					<!-- Controls -->
					<a class="carousel-control-prev" href="#family-carousel" role="button" data-slide="prev">
					   	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					   	<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#family-carousel" role="button" data-slide="next">
					   	<span class="carousel-control-next-icon" aria-hidden="true"></span>
					   	<span class="sr-only">Next</span>
					</a>
				</div>
			<?php
		}
		?>


		<div class="credit">
			<div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
		</div>
		<div class="users-footer">
			<button class="manage-btn" onclick="loadChildren()"><?= $action->trans->read("users","manage") ?></button>
		</div>
<?php
	}

require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");