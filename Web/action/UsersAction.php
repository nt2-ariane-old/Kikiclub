<?php
	require_once("action/CommonAction.php");

	class UsersAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"Users");
		}

		protected function executeAction() {

		}
	}