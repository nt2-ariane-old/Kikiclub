<?php
	require_once("action/CommonAction.php");

	class UsersAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,'users');
		}

		protected function executeAction() {

		}
	}