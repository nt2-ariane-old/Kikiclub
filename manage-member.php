<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ManageMemberAction.php");

	$action = new ManageMemberAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	if($actionUser->error)
	{
		?>
			<div class="error"><?= $actionUser->errorMsg?></div>
		<?php
	}

	if($actionUser->create)
	{
		?>
			<div id="profil">
				<?php loadProfil(null,$actionUser); ?>

				<div class="credit">
					<div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
				</div>
			</div>
		<?php
	}
	else if($actionUser->update)
	{
		?>
			<div id="profil">
				<?php loadProfil($actionUser->family_member,$actionUser); ?>

				<div class="credit">
					<div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
				</div>
			</div>
		<?php
	}
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");