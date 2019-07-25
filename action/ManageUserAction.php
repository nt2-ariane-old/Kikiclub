<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class ManageUserAction extends CommonAction {

		//mode
		public $create;
		public $update;
		//utilities

		//user info
		public $id_user;
		public $user;

		public $added;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'manage-user','Manage User');
			$this->add = false;
			$this->update = false;
			$this->added = false;
		}

		protected function executeAction() {

			if(!empty($_SESSION["users_action"]))
			{
				if($_SESSION["users_action"] == "create")
				{
					$this->create = true;
					$this->complete_name = "Create User";
				}
				else if($_SESSION["users_action"] == "update")
				{
					$this->update = true;
					$this->complete_name = "Manage User";

					if(empty($_SESSION["user_id"]))
					{
						header("Location:users.php");
					}
					else
					{
						$this->id_user =$_SESSION["user_id"];
					}

				}
			}
			else
			{
				header("Location:users.php");
			}

			if($this->create)
			{
				if(isset($_POST['push']))
				{
					UsersDAO::registerUser($_POST['email'],null,null,$_POST['firstname'],$_POST['lastname'],CommonAction::$VISIBILITY_CUSTOMER_USER,null);
					$this->added = true;
					$this->create = false;
					$this->update = true;
					$this->id_user = UsersDAO::getUserWithEmail($_POST['email'])["ID"];
					$_SESSION["user_id"] = $this->id_user;
					$_SESSION["users_action"] = "update";
				}
			}
			if($this->update)
			{
				$this->user =  FamilyDAO::getUserFamily($this->id_user);
				if(isset($_POST['push']))
				{
					UsersDAO::updateUser($this->id_user,$_POST['email'],$_POST['firstname'],$_POST['lastname']);
				}
				if(isset($_POST['delete']))
				{
					UsersDAO::deleteUser($this->id_user);
					header('location:users.php');
				}
			}


		}

	}