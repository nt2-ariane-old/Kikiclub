<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UsersDAO.php");

	class FamilyAjaxAction extends CommonAction {
		public $results;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"family ajax");
		}

		protected function executeAction() {
			if(!empty($_SESSION["ID"]))
			{
				$parent = UsersDAO::getParent($_SESSION["ID"]);
				$this->results = UsersDAO::getFamily($parent["ID"]);
			}
		}
	}