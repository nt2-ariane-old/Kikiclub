<?php
	require_once("action/DAO/FamilyDAO.php");
	class ShowUsersAction {

		public $create;
		public $modify;

		public $avatars;
		public $genders;

		public $error;
		public $family_member;
		public $errorMsg;
		public $page_name = 'show-users';
		public function __construct() {
			$this->create = false;
			$this->modify = false;
		}

		public function execute() {
			$script = $_SERVER['SCRIPT_NAME'];
			 if($script == "/kikiclub/web/show-users.php")
			 {
			 	header('Location:users.php');
			 } else if($script == "/show-users.php")
			 {
			 	header('Location:users.php');
			 }


			 $this->genders = FamilyDAO::getGenders();

			 if(!empty($_POST["action"]))
			{
				if($_POST["action"] == "create")
				{
					$this->create = true;
				}
				else if($_POST["action"] == "modify")
				{
					$this->modify = true;
				}
			}

			if($this->create)
			{

				$this->avatars = FamilyDAO::loadAvatar();

				if(isset($_POST["form"]))
				{


					if( !empty($_POST["firstname"]) &&
						!empty($_POST["lastname"]) &&
						!empty($_POST["birth"]))
						{
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
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

			}
			else if($this->modify)
			{
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
						unset($_SESSION["member"]);
						?>
							<script>window.location="users.php";</script>
						<?php

					}
				}


			}


		}
	}