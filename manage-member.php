<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/ManageMemberAction.php");

	$action = new ManageMemberAction();
	$action->execute();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/header.php");

	?>
	<div id="profil">
		<?php 
			$userExist = false;
			if($action->member != null)
			{
				$userExist = true;
			}
		?>
			<div class="users-contents">
				<?php
				if($action->error)
				{
				?>
					<div class="error"><?= $action->errorMsg?></div>
				<?php
				}
				?>
				<div class="sheet">
					<h3><?= $action->trans->read("manage-member","profil")?></h3>
					<form id="profil-form" action="manage-member.php" method="post">
						<div class="infos">
							<p><input type="text" name="firstname" id="firstname" placeholder="<?= $action->trans->read("manage-member","firstname") ?>" value="<?php if($userExist) echo $action->member["firstname"]  ?>"></p>
							<p><input type="text" name="lastname" id="lasttname" placeholder="<?= $action->trans->read("manage-member","lastname") ?>"  value="<?php if($userExist) echo $action->member["lastname"]  ?>"></p>
							<p><input type="text" name="birth" id="datepicker" placeholder="<?= $action->trans->read("manage-member","birth") ?>"  value="<?php if($userExist) echo $action->member["birthday"]  ?>"></p>
	
							<p><span class="input-title">Gender : </span>
									<select name="gender" id="">
										<?php
											foreach ($action->genders as $gender) {
												?>
													<option <?php if($userExist)if($action->member["id_gender"] == $gender["id"]) echo 'selected' ;?> value="<?= $gender["id"] ?>"><?= $gender["name"] ?></option>
												<?php
											}
										?>
									</select></p>
							</div>
	
							<h3><?= $action->trans->read("manage-member","select-avatar") ?></h3>
	
							<div id="mixedSlider_avatars" class="multislider avatars-list">
								<div class="MS-content">
									<?php
										foreach ($action->avatars as $avatar) {
									?>
										<div class="item">
											<label>
												<?php
													if($userExist && $action->member["id_avatar"] ==  $avatar["id"]){
														?>
															<input type="radio" name="avatar" value="<?=$avatar["id"]?>" checked>
														<?php
													}
													else
													{
														?>
															<input type="radio" name="avatar" value="<?=$avatar["id"]?>">
														<?php
													}
												?>
												<img  style="cursor:pointer;" src="<?=$avatar["media_path"]?>">
											</label>
										</div>
									<?php
										}
									?>
								</div>
								<div class="MS-controls">
									<button type="button" id="btn-left" class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
									<button type="button" id="btn-right" class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
								</div>
							</div>
	
							<div class="forms-btns">
								<button type="submit" class="submit-btn"><?php if($userExist){echo $action->trans->read("all_pages","update");} else{echo $action->trans->read("all_pages","add");} ?></button>
								<?php
								if($userExist)
								{
									?>
										<a class="delete-btn" style="cursor:pointer;" name="delete" onclick="clicked=this.name;openConfirmBox(this.parentElement.parentElement,{type:'post',path:'manage-member.php',params:{ 'delete':true}})"><?= $action->trans->read("all_pages","delete")?></a>
	
									<?php
								}
							?>
							</div>
						</form>
						<?php
							if($action->admin_mode && $userExist)
							{
								?>
									<a class="return-btn" href="assign-member.php")><?= $action->trans->read("manage-member","assign")?></a>
								<?php
							}
						?>
						<div>
							<a class="return-btn" href="<?= $action->previous_page ?>.php"><?= $action->trans->read("all_pages","back") ?></a>
						</div>
	
	
					</div>
	
				</div>
	</div>
	<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . "/partial/footer.php");