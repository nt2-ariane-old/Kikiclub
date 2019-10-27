<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/AllMembersAction.php");

	$action = new AllMembersAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
<div class='form-workshops'>
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
				for ($i=$action->min; $i < $action->max; $i++) { 
					$member = $action->admin_members;
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
	<a href='?page=<?=$action->page - 1?>'><</a><a href='?page=<?=$action->page + 1?>'>></a>

</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");