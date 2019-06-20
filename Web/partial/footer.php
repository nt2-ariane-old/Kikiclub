		<?php
			if($action->page_name != 'users' ||
				$action->page_name != 'console' ||
				$action->page_name != 'login')
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
	</body>
</html>