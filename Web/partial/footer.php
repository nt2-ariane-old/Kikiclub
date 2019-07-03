		<?php
			if($action->page_name != 'users' &&
				$action->page_name != 'console' &&
				$action->isLoggedIn())
			{

				?>
					<div id="profile-box">Profiles
						<div id="x-btn" onclick="closeProfilesBox()"></div>
						<?php
							require_once("show-users.php");
						?>
					</div>

				<?php
			}
		?>
	<?php
		if($action->page_name != "users" && $action->isLoggedIn())
		{
		?>
			<footer>
			@2019 par kikicode
			<a href="https://www.kikicode.ca/" style="background-image:url(images/logoNom.png);"></a>
			<a href="https://www.codecafe.cafe/" style="background-image:url(images/cafeLogo.png);"></a>
			<a href="https://www.facebook.com/kikicode/" style="background-image:url(images/fb.png);"></a>
		</footer>
		<?php
		}
	?>

	</body>
</html>