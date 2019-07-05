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
				if($_POST["isLoggedIn"] == true ||  $_POST["isLoggedIn"] == "true" )
				{
					$id_type = UsersDAO::getLoginTypeIdByName($_POST["type"]);

					if($id_type != -1)
					{
						UsersDAO::RegisterUser($_POST["email"],$_POST["password"],$_POST["password_confirm"],$_POST["firstname"],$_POST["lastname"],$this->default_visibility,$id_type);

						$infos = UsersDAO::loginUserWithEmail($_POST["email"],null,$id_type);
						if(!is_string($infos))
						{
							$token = openssl_random_pseudo_bytes(16);
							$token = bin2hex($token);

							$this->results = true;
						}
						else
						{
							$this->results = false;
						}
					}
					else
					{
						$this->results = false;
					}
				}
				else
				{
					$this->results = false;
				}

			}
			else
			{
				$this->results = false;
			}

		}
	}