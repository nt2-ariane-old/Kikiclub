<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/SharedAction.php");

	$action = new SharedAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");
?>
	<aside id="social">
		<h2><?= $action->trans->read("shared","social") ?></h2>
		<div class="social-media">
			<div class="fb-page" data-href="https://www.facebook.com/kikicode/" data-tabs="timeline" data-width="300" data-height="800" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/kikicode/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/kikicode/">kikicode</a></blockquote></div>
		</div>
	</aside>
	<main>
		<?php
			if($action->isLoggedIn())
			{
		?>
			<section id="add-shared" onsubmit="return false;">
			<h2><?= $action->trans->read("shared","share-experience") ?></h2>
					<form action="shared.php" method="post">
						<input type="text" id="title" name="title" placeholder="<?= $action->trans->read("shared","title") ?>">
						<input type="hidden" name="media_path" id="media_path">
						<input type="hidden" name="media_type" id="media_type">
						<textarea id="content" name="content" cols="30" rows="10" placeholder="<?= $action->trans->read("shared","insert-text") ?>"></textarea>

						<div id="imagedropzone" class="dropzone"></div>

						<button class="send" onclick="loadPosts('insert')"><?= $action->trans->read("shared","send") ?></button>
					</form>

			</section>

		<?php
			}
		?>

		<section id="pages">
		</section>

		<section id="shared-posts">
			<script>loadPosts()</script>
		</section>





	</main>


<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");