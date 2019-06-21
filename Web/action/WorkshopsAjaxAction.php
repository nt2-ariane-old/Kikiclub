<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/RobotDAO.php");
	class WorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"workshops-ajax","Workshops,Ajax");
		}

		protected function executeAction() {
			if(!empty($_POST["id"]))
			{
				$this->results["workshop"] = WorkshopDAO::selectWorkshop($_POST["id"]);
				$this->results["robots"] = RobotDao::getRobots();

			}
			if(!empty($_POST["sort"]))
			{
				switch ($_POST["sort"]) {
					case 'none':
						$this->results=WorkshopDAO::getWorkshops();
						break;
					case 'ascName':
						$this->results=WorkshopDAO::getWorkshops("NAME",true);
						break;
					case 'descName':
						$this->results=WorkshopDAO::getWorkshops("NAME",false);
						break;
					case 'recents':
						$this->results=WorkshopDAO::getWorkshops("ID");
						break;
				}
			}
		}
	}