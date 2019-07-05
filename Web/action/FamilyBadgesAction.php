<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/BadgeDAO.php");
	require_once("action/DAO/FamilyDAO.php");

	class FamilyBadgesAction extends CommonAction {
		public $badges;
		public $family_pts;
		public $member_pts;
		public $is_member;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,'family-badges','Badges');
		}

		protected function executeAction() {
			$id_user = $_SESSION["id"];
			$family = FamilyDAO::selectFamilyMembers($id_user);
			if(!empty($_SESSION["member"]))
			{
				$this->badges = BadgeDAO::getFamilyBadges($id_user,$_SESSION["member"]);
				$this->is_member = true;
				$this->member_pts = FamilyDAO::selectMember($_SESSION["member"])["score"] ;
			}
			else
			{
				$this->badges = BadgeDAO::getFamilyBadges($id_user);
			}

			$this->family_pts = 0;
			foreach ($family as $member) {
				$this->family_pts += $member["score"];
			}

		}
	}