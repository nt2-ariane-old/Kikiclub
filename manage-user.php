<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ManageUserAction.php");

	$action = new ManageUserAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	if($action->create)
	{
		?>
			<div class="sheet">
				<?php
					if($action->added)
					{
						?>
					<div style="background-color:green;color:white;text-align:center;">
						User has been added
					</div>
						<?php
					}
				?>
				<h2>Ajout d'un nouvel Utilisateur</h2>
				<form action="manage-user.php" id="profil-form" method="post">
					<input type="hidden" name="add">
					<input type="hidden" name="users">

					<div class="infos">
						<p><span class="input-title">First Name : </span><input type="text" name="firstname" placeholder="Firstname"></p>
						<p><span class="input-title">Last Name : </span><input type="text" name="lastname" placeholder="Lastname"></p>
						<p><span class="input-title">Email : </span><input type="text" name="email" placeholder="Email"></p>
					</div>

					<div class="forms-btns">
						<button type="submit" class="submit-btn" name="push" onclick="clicked=this.name">Add</button>
						<a href="<?= $action->previous_page ?>.php" class="delete-btn">Back</a>
					</div>
				</form>
			</div>

		<?php
	}
	else if($action->update)
	{
		?>
			<div class="sheet">
				<h2>Modification de <?= $action->user["USER"]["FIRSTNAME"] ?> </h2>
				<form action="manage-user.php" id="profil-form" method="post" onSubmit="return validTab(this)">
					<div class="infos">
						<p><span class="input-title">First Name : </span><input type="text" name="firstname" value="<?= $action->user["USER"]["FIRSTNAME"] ?>" placeholder="Firstname"></p>
						<p><span class="input-title">Last Name : </span><input type="text" name="lastname" value="<?= $action->user["USER"]["LASTNAME"] ?>" placeholder="Lastname"></p>
						<p><span class="input-title">Email : </span><input type="text" name="email" value="<?= $action->user["USER"]["EMAIL"] ?>" placeholder="Email"></p>
					</div>

					<div class="forms-btns">
						<button type="submit" class="submit-btn" name="push" onclick="clicked=this.name">Apply</button>
						<button type="submit" class="delete-btn" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement,{type:'form'})">Delete</button>
					</div>
				</form>
				<div class="family">
					<?php
						if(sizeof($action->user["FAMILY"]) > 0)
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
										foreach ($action->user["FAMILY"] as $member)
										{
									?>
											<tr onclick="change_page('manage-member.php',{'member_id':<?= $member['ID'] ?>,'members_action':'update'})">
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
				</div>
				<div>
					<a class="return-btn" href="users.php"><?= $action->trans->read("users","return") ?></a>
				</div>
			</div>

		<?php
	}

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");