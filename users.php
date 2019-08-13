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
	<template id="member-template">
		<div class='member-info'>
			<button href="#"><div class='member-logo'></div><div class='member-stateLogo'></div></button>
			<h2 class='member-name'></h2>
			<p class='member-nbWorkshops'></p>
			<p class='member-nbPTS'></p>
			<div class='member-nbalert'></div>
		</div>
	</template>

	<main>

		<div id="family-carousel" class="multislider" data-interval="false">
			<div class="MS-content" id="family">
				<script>loadMembers(true)</script>
			</div>
			<div class="MS-controls">
				<button id="btn-left" class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
				<button id="btn-right" class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
			</div>
		</div>
	</main>

	<div class="users-footer">
		<button class="manage-btn" onclick="loadMembers()"><?= $action->trans->read("users","manage") ?></button>
	</div>
<?php
	}

require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");