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
				$_SESSION["mode"] = "normal";
			}
			$script = $_SERVER['SCRIPT_NAME'];

			if($script == "/kikiclub/web/show-users.php")
			{
				header('Location:users.php');
			} else if($script == "/show-users.php")
			{
				header('Location:users.php');
			}
			if(!empty($_GET["mode"]))
			{
				if($_GET["mode"] == "normal")
				{
					$_SESSION["mode"] = "normal";
				}
				else if($_GET["mode"] == "create")
				{
					$_SESSION["mode"] = "create";
				}
				else if($_GET["mode"] == "manage")
				{
					$_SESSION["mode"] = "manage";
				}
				else if($_GET["mode"] == "modify")
				{
					$_SESSION["mode"] = "modify";
				}
			}

			if(empty($_SESSION["mode"]))
			{
				$_SESSION["mode"] = "normal";
			}
			if($_SESSION["mode"] == "manage")
			{
				$this->manage = true;
			}
			else if($_SESSION["mode"] == "create")
			{
				$this->create = true;
				$this->avatars = FamilyDAO::loadAvatar();

				if(!empty($_POST["form"]))
				{
					if( !empty($_POST["firstname"]) &&
						!empty($_POST["lastname"]) &&
						!empty($_POST["birth"]))
						{
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
							$_SESSION["mode"] = "normal";
							header("Location:users.php?mode=manage");
						}
						else
						{
							$this->error=true;
							$this->errorMsg = "You need to fill all Feeld...";
						}
				}

			} else if($_SESSION["mode"] == "modify")
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
								$_SESSION["mode"] = "normal";
								header("Location:users.php?mode=manage");
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
						$_SESSION["mode"] = "normal";
						header("Location:users.php?mode=manage");
					}
				}


			}


		}
	}