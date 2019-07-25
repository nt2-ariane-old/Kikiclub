<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");

	class ManageMemberAction extends CommonAction {

		//mode
		public $create;
		public $update;

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
			$this->create = false;
			$this->update = false;
		}

		protected function executeAction() {

			if(!empty($_SESSION["members_action"]))
			{
				if($_SESSION["members_action"] == "create")
				{
					$this->create = true;
				}
				else if($_SESSION["members_action"] == "update")
				{
					$this->update = true;
					if(empty($_SESSION["member_id"]))
					{
						header("Location:'. $this->previous_page . '.php");
					}

				}
			}



			$this->genders = MemberDAO::getGenders();

			$this->avatars = MemberDAO::loadAvatar();

			if($this->admin_mode && !empty($_SESSION["user_id"]))
			{
				$id = $_SESSION["user_id"];
			}
			else
			{
				$id = $_SESSION["id"];
			}

			if($this->create)
			{
				if(isset($_POST["form"]))
				{


					if( !empty($_POST["firstname"]) &&
						!empty($_POST["lastname"]) &&
						!empty($_POST["birth"]))
						{

							MemberDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$id);
							$this->create = false;
							$this->update = true;
							$member = MemberDAO::getMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$id);
							var_dump($member);
							$_SESSION["member_id"] = $member["id"];
						}
						else
						{
							$this->error=true;
							$this->errorMsg = "You need to fill all Feeld...";
						}
				}

			}
			if($this->update)
			{
				if(!empty($_SESSION["member_id"]))
				{
					echo $_SESSION["member_id"];
					$this->family_member = MemberDAO::selectMember($_SESSION["member_id"]);
					if(isset($_POST["form"]))
					{
						if( !empty($_POST["firstname"]) &&
							!empty($_POST["lastname"]) &&
							!empty($_POST["birth"]))
							{
								MemberDAO::updateFamilyMember($_SESSION["member_id"],$_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"]);
							}
							else
							{
								$this->error=true;
								$this->errorMsg = "You need to fill all Feeld...";
							}
					}
					if(isset($_POST["delete"]))
					{
						MemberDAO::deleteFamilyMember($_SESSION["member_id"]);
						unset($_SESSION["member_id"]);
						header('location:'. $this->previous_page . '.php');
					}
				}


			}
		}
	}