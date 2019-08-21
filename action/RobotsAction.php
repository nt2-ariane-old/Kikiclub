<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");

	class RobotsAction extends CommonAction {

		public $robots;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'robots');
		}

		protected function executeAction() {
			$this->robots = RobotDAO::getRobots();
		}
	}