<?php
	require_once("action/DAO/FamilyDAO.php");
	class ShowUsersAction {

		public $create;
		public $manage;
		public $modify;

		public $avatars;

		public $trans;

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
			if(isset($_POST["normal"]))
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
			if(!empty($_POST["usermode"]))
			{
				if($_POST["usermode"] == "normal")
				{
					$_SESSION["usermode"] = "normal";
				}
				else if($_POST["usermode"] == "create")
				{
					$_SESSION["usermode"] = "create";
				}
				else if($_POST["usermode"] == "manage")
				{
					$_SESSION["usermode"] = "manage";
				}
				else if($_POST["usermode"] == "modify")
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

				if(isset($_POST["form"]))
				{


					if( !empty($_POST["firstname"]) &&
						!empty($_POST["lastname"]) &&
						!empty($_POST["birth"]))
						{
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
							$_SESSION["usermode"] = "manage";
							?>
								<script>window.location = "users.php"</script>
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
					if(isset($_POST["form"]))
					{
						if( !empty($_POST["firstname"]) &&
							!empty($_POST["lastname"]) &&
							!empty($_POST["birth"]))
							{
								FamilyDAO::updateFamilyMember($_SESSION["member"],$_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"]);
								$_SESSION["usermode"] = "manage";
								?>
									<script>window.location = 'users.php'</script>
								<?php
							}
							else
							{
								$this->error=true;
								$this->errorMsg = "You need to fill all Feeld...";
							}
					}
					if(isset($_POST["delete"]))
					{
						FamilyDAO::deleteFamilyMember($_SESSION["member"]);
						$_SESSION["usermode"] = "manage";
						unset($_SESSION["member"]);
						?>
							<script>window.location="users.php";</script>
						<?php

					}
				}


			}


		}
	}