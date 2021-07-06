<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/AllUsersAction.php");

	$action = new AllUsersAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
<div class='form-workshops'>
	<h2><?= $action->trans->read("admin","users") ?></h2>
	<table  class='table table-striped table-hover' style="width:100%" id="usersTable">
		<thead>
			<tr class="rowMember">
				<th style="width:10%;"><?= $action->trans->read("admin","firstname") ?></th>
				<th style="width:10%;"><?= $action->trans->read("admin","lastname") ?></th>
				<th style="width:15%;"><?= $action->trans->read("admin","mail") ?></th>
				<th style="width:15%;">Dernière Connection</th>
				<th style="width:15%;">Date de Création</th>
			</tr>
		</thead>
		<tbody id="table-users">
			<?php
				for ($i=$action->min; $i < $action->max; $i++) { 
					$user = $action->users[$i];
					?>
						<a><tr onclick="change_page('manage-user.php',{'user_id':<?= $user['id'] ?>})">
							<td><?= $user["firstname"] ?></td>
							<td><?= $user["lastname"] ?></td>
							<td><?= $user["email"] ?></td>
							<td><?= $user["last_connected"] ?></td>
							<td><?= $user["date_creation"] ?></td>
						</tr></a>
					<?php
				}
			?>
		</tbody>
	</table>
		<a href='?page=<?=$action->page - 1?>'><</a><a href='?page=<?=$action->page + 1?>'>></a>
</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");