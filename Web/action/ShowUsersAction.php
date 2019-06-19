<?php
	require_once("action/DAO/FamilyDAO.php");
	class ShowUsersAction {
		public $create;
		public $manage;
		public $modify;

		public $avatars;

		public $error;
		public $family_member;
		public $errorMsg;
		public $page_name = 'show-users';
		public function __construct() {
			$this->createFamily = false;
			$this->management = false;
			$this->modify = false;
		}

		public function execute() {
			if(isset($_GET["normal"]))
			{
				$_SESSION["usermode"] = "normal";
			}
			$script = $_SERVER['SCRIPT_NAME'];

			 if($script == "/kikiclub/web/show-users.php")
			 {
			 	header('Location:users.php');
			 } else if($script == "/show-users.php")
			 {
			 	header('Location:users.php');
			 }
			if(!empty($_GET["usermode"]))
			{
				if($_GET["usermode"] == "normal")
				{
					$_SESSION["usermode"] = "normal";
				}
				else if($_GET["usermode"] == "create")
				{
					$_SESSION["usermode"] = "create";
				}
				else if($_GET["usermode"] == "manage")
				{
					$_SESSION["usermode"] = "manage";
				}
				else if($_GET["usermode"] == "modify")
				{
					$_SESSION["usermode"] = "modify";
				}
			}

			if(empty($_SESSION["usermode"]))
			{
				$_SESSION["usermode"] = "normal";
			}
			if($_SESSION["usermode"] == "create")
			{
				$this->create = true;
				$this->avatars = FamilyDAO::loadAvatar();
				var_dump($_POST);

				if(isset($_POST["form"]))
				{

					if( !empty($_POST["firstname"]) &&
						!empty($_POST["lastname"]) &&
						!empty($_POST["birth"]))
						{
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
							$_SESSION["usermode"] = "normal";
							?>
								<script>window.location.replace("users.php?usermode=manage");</script>
							<?php
						}
						else
						{
							$this->error=true;
							$this->errorMsg = "You need to fill all Feeld...";
						}
				}

			} else if($_SESSION["usermode"] == "modify")
			{
				$this->modify = true;
				$this->avatars = FamilyDAO::loadAvatar();
				if(!empty($_SESSION["member"]))
				{
					$this->family_member = FamilyDAO::selectMember($_SESSION["member"]);
					if(!empty($_POST["form"]))
					{
						if( !empty($_POST["firstname"]) &&
							!empty($_POST["lastname"]) &&
							!empty($_POST["birth"]))
							{
								FamilyDAO::updateFamilyMember($_SESSION["member"],$_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"]);
								$_SESSION["usermode"] = "normal";
								?>
									<script>window.location.replace("users.php?usermode=manage");</script>
								<?php
							}
							else
							{
								$this->error=true;
								$this->errorMsg = "You need to fill all Feeld...";
							}
					}
					if(!empty($_GET["delete"]))
					{
						FamilyDAO::deleteFamilyMember($_SESSION["member"]);
						$_SESSION["usermode"] = "normal";
						?>
							<script>window.location.replace("users.php?usermode=manage");</script>
						<?php

					}
				}


			}


		}
	}