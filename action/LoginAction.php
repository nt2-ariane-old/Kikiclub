<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersDAO.php");

	class LoginAction extends CommonAction {
		public $otherlogin;
		public $signup;
		public $error;
		public $errorMsg;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "login");
			$this->otherlogin = false;
			$this->error = false;
		}

		protected function executeAction() {
			if($this->url !== "localhost")
			{
				header('Location:https://kikinumerique.wixsite.com/kikiclubsandbox/blank-5');
			}

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
							$_SESSION["visibility"] = $infos["visibility"];
							$_SESSION["id"] = $infos["id"];
						}
					} else {
						$this->error = true;
						$this->errorMsg =$this->trans->read("login", "errorFeeld");
					}
				}


			}
			else if(!empty($_GET["signup"]))
			{
				$this->signup = true;
				$id_type = UsersDAO::getLoginTypeIdByName("Kikiclub");

				if(isset($_POST["form"]))
				{
					if(!empty($_POST["email"]) &&
					!empty($_POST["psswd1"]) &&
					!empty($_POST["psswd2"])  &&
					!empty($_POST["firstname"])  &&
					!empty($_POST["lastname"]))
					{
						if(UsersDAO::RegisterUser($_POST["email"],$_POST["psswd1"],$_POST["psswd2"],$_POST["firstname"],$_POST["lastname"],$this->default_visibility,$id_type))
						{
							$infos = UsersDAO::loginUserWithEmail($_POST["email"],$_POST["psswd1"],$id_type);
							if(!is_string($infos))
							{
								$_SESSION["id"] = $infos["id"];
								$_SESSION["visibility"] =$infos["visibility"];
							}
							else
							{
								$this->error = true;
								$this->errorMsg = $infos;
							}

						}
						else
						{
							$this->error = true;
							$this->errorMsg = "Not working";
						}
					}
					else
					{
						$this->error = true;
						$this->errorMsg = $this->trans->read("login", "errorFeeld");
					}
				}


			}
			if($this->isLoggedIn())
			{
				header("location:users.php");
			}

		}
	}