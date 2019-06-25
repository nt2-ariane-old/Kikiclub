<?php
	require_once("action/CommonAction.php");

	class UsersAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,'users',"Home");
		}

		protected function executeAction() {
			$this->complete_name = $this->trans->read("main","home");
		}
	}