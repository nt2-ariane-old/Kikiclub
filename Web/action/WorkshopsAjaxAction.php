<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/RobotDAO.php");
	class WorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"workshops-ajax");
		}

		protected function executeAction() {
			if(!empty($_POST["id"]))
			{
				$this->results["workshop"] = WorkshopDAO::selectWorkshop($_POST["id"]);
				$this->results["robots"] = RobotDao::getRobots();

			}
		}
	}