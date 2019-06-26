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
				$id_type = UsersDAO::getLoginTypeIdByName("Kikiclub");
				$this->otherlogin = true;
				
				if(isset($_POST["form"]))
				{
					if(!empty($_POST["email"]) &&
					!empty($_POST["psswd"]))
					{
						$infos = UsersDAO::loginUserWithEmail($_POST["email"],$_POST["psswd"],$id_type);
						if(is_string($infos))
						{
							$this->error = true;
							$this->errorMsg = $infos;
						} 
						else
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
				else
				{
					$this->error = true;
					$this->errorMsg = 'not yet...';
				}
				
			}
			else if(!empty($_GET["signup"]))
			{
				$this->signup = true;
				
				if(isset($_POST["form"]))
				{
					if(!empty($_POST["email"]) &&
					!empty($_POST["psswd1"]) &&
					!empty($_POST["psswd2"])  &&
					!empty($_POST["firstname"])  &&
					!empty($_POST["lastname"]))
					{
						if(UsersDAO::RegisterUser($_POST["email"],$_POST["psswd1"],$_POST["firstname"],$_POST["lastname"],$this->default_visibility,$id_type))
						{
							$_SESSION["visibility"] =$this->default_visibility;
						}
					}
					else
					{
						$this->error = true;
						$this->errorMsg = $this->trans->read("loginpage", "errorFeeld");
					}
				}
				else
				{
					$this->error = true;
					$this->errorMsg = 'not yet...';
				}
				
			}
			if($this->isLoggedIn())
			{
				header("location:users.php");
			}

		}
	}