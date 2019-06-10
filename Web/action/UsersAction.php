<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/FamilyDAO.php");

	class UsersAction extends CommonAction {
		public $create;
		public $avatars;
		public $manage;
		public $error;
		public $errorMsg;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"Users");
			$this->createFamily = false;
			$this->management = false;
		}

		protected function executeAction() {
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
					var_dump($_POST);
					if( !empty($_POST["firstname"]))
						{
							echo("test");
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
							$_SESSION["mode"] = "normal";
							header("location:users.php");
						}
						else
						{
							$this->error=true;
							$this->errorMsg = "You need to fill all Feeld...";
						}
				}

			}


		}
	}