<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/UsersAction.php");

	$action = new UsersAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	if($action->anim_mode)
	{
		?>





	<div class="sheet">

		<div class="part">

			<div class="bar">
				<h3><?= $action->trans->read("admin","search-all") ?></h3>
				<div>
					<div class="autocomplete" style="width:300px;">
					<input id="search-all" type="text" name="search" placeholder="<?= $action->trans->read("admin","all-field") ?>">
				</div>
			</div>
			<!-- <h3><?= '' //$action->trans->read("admin","search-user") ?></h3>
			<div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-user-firstname" type="text" name="search" placeholder="<?= $action->trans->read("admin","firstname") ?>">
				</div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-user-lastname" type="text" name="search" placeholder="<?= $action->trans->read("admin","lastname") ?>">
				</div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-user-email" type="text" name="search" placeholder="<?= $action->trans->read("admin","mail") ?>">
				</div>
			</div>
			<h3><?= '' //$action->trans->read("admin","search-member")?></h3>
			<div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-member-firstname" type="text" name="search" onkeyup="searchMember(this,'firstname')" placeholder="<?= $action->trans->read("admin","firstname") ?>">
				</div>
				<div class="autocomplete" style="width:300px;">
					<input id="search-member-lastname" type="text" name="search" onkeyup="searchMember(this,'lastname')" placeholder="<?= $action->trans->read("admin","lastname") ?>">
				</div>
			</div> -->
		</div>

	</div>
	<div class='part'>
			<button class="submit-btn" onclick="change_page('manage-user.php',{'user_id':null})"><?= $action->trans->read("admin","new-user") ?></button>
			<a class="submit-btn" href="today-members.php"><?= $action->trans->read("pages_name","today") ?></a>
			<a class="submit-btn" href="all-users.php">Tous les utilisateurs</a>
			<a class="submit-btn" href="all-members.php">Tous les membres</a>
		</div>
							<?php
			if(!empty($action->users) || !empty($action->admin_members))
			{
				?>
					<div class='form-workshops'>
						<?php
							if(!empty($action->users))
							{
								?>
							<h2><?= $action->trans->read("admin","users") ?></h2>
							<table  class='table table-striped table-hover' style="width:100%" id="usersTable">
									<thead>
										<tr class="rowMember">
											<th style="width:10%;"><?= $action->trans->read("admin","firstname") ?></th>
											<th style="width:10%;"><?= $action->trans->read("admin","lastname") ?></th>
											<th style="width:15%;"><?= $action->trans->read("admin","mail") ?></th>
										</tr>
									</thead>
									<tbody id="table-users">
										<?php
										foreach ($action->users as $user) {
											?>
										<tr onclick="change_page('manage-user.php',{'user_id':<?= $user['id'] ?>})">
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
							if (!empty($action->admin_members))
							{
								?>
							<h2><?= $action->trans->read("admin","members") ?></h2>
							<table>
								<thead>
									<tr>
										<th><?= $action->trans->read("admin","firstname") ?></th>
										<th><?= $action->trans->read("admin","lastname") ?></th>
										<th><?= $action->trans->read("admin","score") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($action->admin_members as $member) {
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
		<button class="manage-btn" onclick="setManage()"><?= $action->trans->read("users","manage") ?></button>
	</div>
<?php
	}

require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");
