<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UsersDAO.php");
	class LoginAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "loginAjax", "Login","Ajax");

		}

		protected function executeAction() {
			if(!empty($_POST["isLoggedIn"]))
			{
				if($_POST["isLoggedIn"] == true)
				{
					if(!UsersDAO::UserExist($_POST["email"]))
					{
						UsersDAO::RegisterUser($_POST["email"],null,$_POST["name"],$_POST["name"],$this->default_visibility);
						$_SESSION["visibility"] =$this->default_visibility;
					}
					else
					{
						$infos = UsersDAO::login($_POST["email"],null);
						if($infos === null)
						{
							$this->error = true;
							$this->errorMsg = "Email or Password not valid";
						} else
						{
							$_SESSION["visibility"] = $infos["VISIBILITY"];
							$_SESSION["id"] = $infos["ID"];
							$_SESSION["firstname"] = $infos["firstname"];
							$_SESSION["lastname"] = $infos["lastname"];
						}
					}
					$this->results = true;
				}
			}
		}
	}