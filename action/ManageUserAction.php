<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class ManageUserAction extends CommonAction {
		//user info
		public $id_user;
		public $user;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'manage-user');
			
		}

		protected function executeAction() {

			if(!empty($_SESSION["user_id"]))
			{
				$this->id_user =$_SESSION["user_id"];
				$this->user =  MemberDAO::getUserFamily($this->id_user);
			}
			if(isset($_POST['push']))
			{
				if($this->id_user != null)
				{
					UsersDAO::updateUser($this->id_user,$_POST['email'],$_POST['firstname'],$_POST['lastname']);
				}
				else
				{
					UsersDAO::registerUser($_POST['email'],null,null,$_POST['firstname'],$_POST['lastname'],CommonAction::$VISIBILITY_CUSTOMER_USER,null);
				}
				header('location:users.php');
			}
			if(isset($_POST['delete']))
			{
				UsersDAO::deleteUser($this->id_user);
				header('location:users.php');
			}
		}

	}