<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ConsoleAction.php");

	$action = new ConsoleAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<div class="sheet">
		<h2>Utilisateurs ne s'étant jamais connectés :</h2>
		<ul>
			<?php
				foreach ($action->users as $user) {
					?>
						<li><?= $user['firstname'] ?> <?= $user['lastname'] ?> => <?= $user['email'] ?></li>
					<?php
				}
			?>
		</ul>
	</div>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");