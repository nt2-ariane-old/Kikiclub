<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ManageUserAction.php");

	$action = new ManageUserAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	?>
		<?php
			$existe = false;
			if($action->user != null)
			{
				$existe = true;
			}
		?>
		<main>
			<div class="sheet">
				<h2><?php if($existe) echo $action->trans->read("manage-user","modification"); else echo $action->trans->read("manage-user","adding") ?></h2>
				<form action="manage-user.php" id="profil-form" method="post" onSubmit="return validTab(this)">
					<div class="infos">
						<p><span class="input-title"><?= $action->trans->read("manage-user","firstname") ?> : </span><input type="text" name="firstname" value="<?= $action->user["user"]["firstname"] ?>" placeholder="<?= $action->trans->read("manage-user","firstname") ?>"></p>
						<p><span class="input-title"><?= $action->trans->read("manage-user","lastname") ?> : </span><input type="text" name="lastname" value="<?= $action->user["user"]["lastname"] ?>" placeholder="<?= $action->trans->read("manage-user","lastname") ?>"></p>
						<p><span class="input-title"><?= $action->trans->read("manage-user","mail") ?> : </span><input type="text" name="email" value="<?= $action->user["user"]["email"] ?>" placeholder="<?= $action->trans->read("manage-user","mail") ?>"></p>
						<p><span class="input-title"><?= $action->trans->read("manage-user","admin") ?></span>
							<select name="admin" id="">
								<option value="1" <?php if($action->user['user']['visibility'] == 1) echo 'selected';?>>Client</option>
								<option value="2" <?php if($action->user['user']['visibility'] == 2) echo 'selected';?>>Animateur</option>
								<option value="3" <?php if($action->user['user']['visibility'] == 3) echo 'selected';?>>Moderateur</option>
								<option value="4" <?php if($action->user['user']['visibility'] == 4) echo 'selected';?>>Administrateur</option>
								<option value="5" <?php if($action->user['user']['visibility'] == 5) echo 'selected';?>>Propriétaire</option>		
							</select>
						</p>
					</div>
					<div class="forms-btns">
						<button type="submit" class="submit-btn" name="push" onclick="clicked=this.name"><?php if($existe) echo $action->trans->read("all_pages","apply"); else echo $action->trans->read("all_pages","create"); ?></button>
						<?php
							if($existe)
							{
						?>
								<button type="submit" class="delete-btn" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement,{type:'form'})"><?= $action->trans->read("all_pages","delete") ?></button>
						<?php
							}
						?>
					</div>
				</form>
				<?php
					if($existe)
					{
						?>

						
				<div class="family">
					<table>
						<thead>
							<tr>
								<th><?= $action->trans->read("manage-user","firstname") ?></th>
								<th><?= $action->trans->read("manage-user","lastname") ?></th>
								<th><?= $action->trans->read("manage-user","score") ?></th>
							</tr>
						</thead>
						<tbody>
							
							<?php
								if(sizeof($action->user["family"]) > 0)
								{
									foreach ($action->user["family"] as $member)
									{
										?>
											<tr style="cursor:pointer;" onclick="change_page('manage-member.php',{'member_id':<?= $member['id'] ?>,'members_action':'update'})">
												<td><?= $member["firstname"] ?></td>
												<td><?= $member["lastname"] ?></td>
												<td><?= $member["score"] ?></td>
											</tr>
										<?php
									}	
								}
						?>
							<tr style="cursor:pointer;" onclick="change_page('manage-member.php',{'member_id':null,'members_action':'create'})">
								<td > <?= $action->trans->read("all_pages","add")?> </td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php
					}
					?>
				<div>
					<a class="return-btn" href="users.php"><?= $action->trans->read("all_pages","back") ?></a>
				</div>
			</div>
		</main>
	<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");