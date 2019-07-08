<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/BadgeDAO.php");
	require_once("action/DAO/FamilyDAO.php");

	class BadgesAction extends CommonAction {
		public $badges;
		public $family_pts;
		public $member_pts;
		public $is_member;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,'family-badges','Badges');
		}

		protected function executeAction() {
			$this->badges = BadgeDAO::getBadges();


		}
	}