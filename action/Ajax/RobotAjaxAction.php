<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/FilterDAO.php");

	class RobotAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'robot-ajax','Robot Ajax');
		}

		protected function executeAction() {
			if(!empty($_POST["id"]))
			{
				$this->results["robot"] = RobotDAO::getRobotByID($_POST["id"]);
				$this->results["grade"] = FilterDAO::getGradeById($this->results["robot"]['id_grade']);
			}
		}
	}