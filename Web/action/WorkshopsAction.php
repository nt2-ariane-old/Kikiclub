<?php
	require_once("action/CommonAction.php");

	class WorkshopsAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER);
		}

		protected function executeAction() {
			if(!empty())
		}
	}