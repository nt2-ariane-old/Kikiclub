<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UsersDAO.php");
	class LoginAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "loginAjax", "Login","Ajax");
			$this->results = false;				

		}

		protected function executeAction() {
			if(!empty($_POST["isLoggedIn"]))
			{
				if($_POST["isLoggedIn"] == true)
				{
					$id_type = UsersDAO::getLoginTypeIdByName($_POST["type"]);
					
					if(UsersDAO::RegisterUser($_POST["email"],$_POST["password"],$_POST["password_confirm"],$_POST["name"],$_POST["name"],$this->default_visibility,$id_type))
					{
						$user = UsersDAO::getUserWithEmail($_POST["email"]);
						
						$_SESSION["visibility"] = $infos["VISIBILITY"];
						$_SESSION["id"] = $infos["ID"];
						$_SESSION["firstname"] = $infos["FIRSTNAME"];
						$_SESSION["lastname"] = $infos["LASTNAME"];

						$this->results = true;
					}
					else
					{
						$infos = UsersDAO::loginUserWithEmail($_POST["email"],null,$id_type);
						if(is_string($infos))
						{
							$this->results = $infos;
						}
						else
						{
							$_SESSION["visibility"] = $infos["VISIBILITY"];
							$_SESSION["id"] = $infos["ID"];
							$_SESSION["firstname"] = $infos["FIRSTNAME"];
							$_SESSION["lastname"] = $infos["LASTNAME"];
							
							$this->results = true;			
						}
					}
					
				}
			}
		}
	}