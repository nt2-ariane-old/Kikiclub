<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class TodayMembersAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ANIMATOR,'today-members');
		}

		protected function executeAction() {
            
		}

	}