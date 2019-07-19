<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class UsersAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'users',"Home");
		}

		protected function executeAction() {
			$this->complete_name = $this->trans->read("main","home");

			unset($_SESSION["member_id"]);

			$this->genders = FamilyDAO::getGenders();


		}
	}