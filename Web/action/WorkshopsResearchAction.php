<?php
	require_once("action/CommonAction.php");

	class WorkshopsResearchAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"workshops-research","Workshops Research");
		}

		protected function executeAction() {

		}
	}