<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/MemberHomeAction.php");

	$action = new MemberHomeAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<main>
		<h2>Workshops</h2>
		<div class="container">
			<div class="row">
				<button onclick="post('workshops.php',{'type':2})" class="access-btn col-lg-3 rounded-circle" id="new">
					New
					<?php
						if($action->member["alert"] > 0)
						{
							?>
								<div class="alert-new"><?=$action->member["alert"]?></div>
							<?php
						}
					?>
				</button>

				<button onclick="post('workshops.php',{'type':3})" class="access-btn col-lg-3 rounded-circle" id="progress">
					In Progress
				</button>
				<button onclick="post('workshops.php',{'type':4})" class="access-btn col-lg-3 rounded-circle" id="complete">
					Complete
				</button>
			</div>
		</div>
		<h2>Badges</h2>
		<?php
			loadBadgesCarousel($action->badges,"badges",$action,"badges",true);
		?>
	</main>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");