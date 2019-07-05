<?php
	require_once("action/CommonAction.php");

	class FamilyBadgesAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,'family-badges','Badges');
		}

		protected function executeAction() {

		}
	}