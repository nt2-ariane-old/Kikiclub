<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UsersDAO.php");

	class LoginAction extends CommonAction {
		public $otherlogin;
		public $signup;
		public $error;
		public $errorMsg;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "login","Login Page");
			$this->otherlogin = false;
			$this->error = false;
		}

		protected function executeAction() {
			if(!empty($_GET["other"]))
			{
				if($_GET["other"] == "true")
				{
					$this->otherlogin = true;
				}


				if(!empty($_POST["email"]) &&
				!empty($_POST["psswd"]))
				{
					$infos = UsersDAO::login($_POST["email"],$_POST["psswd"]);
					if($infos === null)
					{
						$this->error = true;
						$this->errorMsg = $this->trans->read("loginpage", "errorEntry");
					} else
					{
						$_SESSION["visibility"] = $infos["VISIBILITY"];
						$_SESSION["id"] = $infos["ID"];
						$_SESSION["firstname"] = $infos["firstname"];
						$_SESSION["lastname"] = $infos["lastname"];
					}
				} else {
					$this->error = true;
					$this->errorMsg =$this->trans->read("loginpage", "errorFeeld");
				}
			}
			else if(!empty($_GET["signup"]))
			{
				if($_GET["signup"] == "true")
				{
					$this->signup = true;
				}
				if(!empty($_POST["email"]) &&
				!empty($_POST["psswd1"]) &&
				!empty($_POST["psswd2"])  &&
				!empty($_POST["firstname"])  &&
				!empty($_POST["lastname"]))
				{
					if($_POST["psswd1"] === $_POST["psswd2"])
					{
						if(!UsersDAO::UserExist($_POST["email"]))
						{

							UsersDAO::RegisterUser($_POST["email"],$_POST["psswd1"],$_POST["firstname"],$_POST["lastname"],$this->default_visibility);
							$_SESSION["visibility"] =$this->default_visibility;
						}
						else
						{
							$this->error = true;
							$this->errorMsg = $this->trans->read("loginpage", "errorExist");
						}
					} else {
						$this->error = true;
						$this->errorMsg = $this->trans->read("loginpage", "errorPassword");
					}
				}
				else
				{
					$this->error = true;
					$this->errorMsg = $this->trans->read("loginpage", "errorFeeld");
				}
			}
			if($this->isLoggedIn())
			{
				header("location:users.php");
			}

		}
	}