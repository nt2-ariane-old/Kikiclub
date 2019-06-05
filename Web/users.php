<?php
	require_once("action/UsersAction.php");

	$action = new UsersAction();
	$action->execute();

	require_once("partial/header.php");
?>

	<template id="child-template">
		<div class='child'>
			<h2 class='child-name'></h2>
			<p class='child-score'></div>
		</div>
	</template>

	<main>
		<div id="container"></div>
		<script>loadChildren()</script>

	</main>
<?php
	require_once("partial/footer.php");