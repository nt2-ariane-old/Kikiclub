<?php
	require_once("action/CommonAction.php");

	class ConsoleAdminAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER);
		}

		protected function executeAction() {

		}
	}