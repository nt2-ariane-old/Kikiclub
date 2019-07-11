<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/FamilyDAO.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/BadgeDAO.php");

	class MemberHomeAction extends CommonAction {
		public $member;
		public $badges;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'member-home','Member Home');
		}

		protected function executeAction() {
			if(!empty($_POST["member"]))
			{
				$_SESSION["member"] = $_POST["member"];
			}
			else if(empty($_SESSION["member"]))
			{
				header('location:users.php');
			}


			$id = $_SESSION["member"];
			$this->member = FamilyDAO::selectMember($id);

			$this->member["alert"] = sizeof(WorkshopDAO::selectMemberNotStartedWorkshop($id));
			$this->complete_name = $this->member["firstname"] . "'s Page";

			$this->badges = BadgeDAO::getMemberBadge($id);
		}
	}