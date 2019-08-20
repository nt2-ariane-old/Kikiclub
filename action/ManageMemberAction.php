<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");

	class ManageMemberAction extends CommonAction {

		//utilities
		public $avatars;
		public $genders;

		//member info
		public $member;

		//error management
		public $error;
		public $errorMsg;



		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,"manage-member","Manage Member");
		}

		protected function executeAction() {

			$this->genders = MemberDAO::getGenders();

			if($this->admin_mode && !empty($_SESSION["user_id"]))
			{
				$id = $_SESSION["user_id"];
			}
			else
			{
				$id = $_SESSION["id"];
			}
			$id_member = -1;
			if(!empty($_SESSION["member_id"]))
			{
				$id_member = $_SESSION["member_id"];
				$this->member = MemberDAO::selectMember($id_member);
			}
			if(!empty($_POST))
			{
				if( !empty($_POST["firstname"]) &&
					!empty($_POST["lastname"]) &&
					!empty($_POST["birth"]))
					{
						if($id_member >= 0)
						{
							MemberDAO::updateFamilyMember($id_member,$_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"]);
						}
						else
						{
							MemberDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$id);
						}
						header('Location:'.$this->previous_page);
					}
				else
					{
						$this->error=true;
						$this->errorMsg = "You need to fill all Feeld...";
					}

			}
			if($id_member >= 0)
			{
				if(isset($_POST["delete"]))
				{
					MemberDAO::deleteFamilyMember($id_member);
					unset($_SESSION["member_id"]);
					header('location:' . $this->previous_page . '.php');
				}
			}
		}
	}