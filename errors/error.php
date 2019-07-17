<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ErrorAction.php");

	$action = new ErrorAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	if ($action->err400) {
		?>
			<h1>ERROR 400 :</h1>
			<h3> Vous n'êtes pas authoriser sur cette page... </h3>
		<?php
	} else if ($action->err401) {
		?>
			<h1>ERROR 401 :</h1>
			<h3> Vous n'êtes pas authoriser sur cette page... Vous avez besoin d'une authorisation.</h3>
		<?php
	} else if ($action->err403) {
		?>
			<h1>ERROR 403 :</h1>
			<h3> Désolé, vous n'avez pas accès à cette page... Interdit!</h1>
		<?php
	} else if ($action->err404) {
		?>
			<h1>ERROR 404 :</h1>
			<h3> La page que vous recherchez n'existe pas...</h1>
		<?php
	} else if ($action->err500) {
		?>
			<h1>ERROR 500 :</h1>
			<h3> Il y a eu un problème avec le serveur...</h1>
		<?php
	} else {
		?>
			<h1>Aucune Erreur :</h1>
			<h1>Vous vous êtes perdu... Vous n'avez pas d'erreur...</h1>
		<?php
	}

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");