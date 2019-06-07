<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/FamilyDAO.php");

	class FamilyAjaxAction extends CommonAction {
		public $results;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"family ajax");
		}

		protected function executeAction() {
			if(!empty($_SESSION["id"]))
				$this->results["family"] = FamilyDAO::selectFamilyMembers($_SESSION["id"]);
				$this->results["avatars"] = FamilyDAO::loadAvatar();

		}
	}