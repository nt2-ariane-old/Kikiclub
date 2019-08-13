<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ManageMemberAction.php");

	$action = new ManageMemberAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	if($action->error)
	{
		?>
			<div class="error"><?= $action->errorMsg?></div>
		<?php
	}

	?>
	<div id="profil">
		<?php loadProfil($action->member,$action); ?>
	</div>
	<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");