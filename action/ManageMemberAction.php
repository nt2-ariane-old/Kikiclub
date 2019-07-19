<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/FamilyDAO.php");

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



			$this->genders = FamilyDAO::getGenders();

			if($this->create)
			{

				$this->avatars = FamilyDAO::loadAvatar();

				if(isset($_POST["form"]))
				{


					if( !empty($_POST["firstname"]) &&
						!empty($_POST["lastname"]) &&
						!empty($_POST["birth"]))
						{
							FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_SESSION["id"]);
							header('location:'. $this->previous_page . '.php');

						}
						else
						{
							$this->error=true;
							$this->errorMsg = "You need to fill all Feeld...";
						}
				}

			}
			else if($this->update)
			{
				$this->avatars = FamilyDAO::loadAvatar();
				if(!empty($_SESSION["member_id"]))
				{

					$this->family_member = FamilyDAO::selectMember($_SESSION["member_id"]);
					if(isset($_POST["form"]))
					{
						if( !empty($_POST["firstname"]) &&
							!empty($_POST["lastname"]) &&
							!empty($_POST["birth"]))
							{
								FamilyDAO::updateFamilyMember($_SESSION["member_id"],$_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"]);
								header('location:'. $this->previous_page . '.php');
							}
							else
							{
								$this->error=true;
								$this->errorMsg = "You need to fill all Feeld...";
							}
					}
					if(isset($_POST["delete"]))
					{
						FamilyDAO::deleteFamilyMember($_SESSION["member_id"]);
						unset($_SESSION["member_id"]);
						header('location:'. $this->previous_page . '.php');
					}
				}


			}
		}
	}