<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberWorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/BadgeDAO.php");

	class MemberHomeAction extends CommonAction {
		public $member;
		public $won_badges;
		public $all_badges;
		public $workshops_categories;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'member-home','Member Home');
		}

		protected function executeAction() {

			if(empty($_SESSION["member_id"]))
			{
				header('location:users.php');
			}

			$id = $_SESSION["member_id"];
			$this->member = MemberDAO::selectMember($id);
			$this->workshops_categories = MemberWorkshopDAO::selectMemberWorkshopByCategories($id);
			$this->member["alert"] = sizeof(MemberWorkshopDAO::selectMemberNewWorkshop($id));
			$this->complete_name = $this->member["firstname"] . "'s Page";

			$this->won_badges = BadgeDAO::getMemberBadge($id);
			$this->all_badges = BadgeDAO::getBadges();
		}
	}