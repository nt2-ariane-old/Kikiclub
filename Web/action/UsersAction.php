<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/FamilyDAO.php");

	class UsersAction extends CommonAction {
		public $createFamily;
		public $avatars;
		public $management;
		public $error;
		public $errorMsg;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"Users");
			$this->createFamily = false;
			$this->management = false;
		}

		protected function executeAction() {
			if(!empty($_GET["manage"]))
			{
				if($_GET["manage"] == "true")
				{
					$_SESSION["mode"] = "manage";
				}
			}
			if($_SESSION["mode"] = "manage")
			{
				$this->management = true;
			}
			if(!empty($_GET["user"]))
			{
				if($_GET["user"]=="new")
				{
					$this->createFamily = true;
					$this->avatars = FamilyDAO::loadAvatar();
					if(!empty($_POST["firstname"]) &&
						!empty($_POST["lasttname"]) &&
						!empty($_POST["avatar"]) &&
						!empty($_POST["gender"]) &&
						!empty($_POST["birth"]))
						{
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lasttname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
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