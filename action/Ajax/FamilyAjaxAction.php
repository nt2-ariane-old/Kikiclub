<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/FamilyDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");

	class FamilyAjaxAction extends CommonAction {
		public $results;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,"family-ajax", "Family,Ajax");
		}

		protected function executeAction() {
			if(!empty($_SESSION["id"]))
				$this->results["family"] = FamilyDAO::selectFamily($_SESSION["id"]);
				$this->results["avatars"] = FamilyDAO::loadAvatar();
				if(!empty($this->results["family"]))
				{
					foreach ($this->results["family"] as $key => $value) {
						$this->results["family"][$key]["workshops"] = WorkshopDAO::selectMemberWorkshop($this->results["family"][$key]["id"]);
						$this->results["family"][$key]["alert"] = WorkshopDAO::selectMemberNewWorkshop($this->results["family"][$key]["id"]);
					}
				}

		}
	}