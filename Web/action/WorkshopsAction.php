<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/RobotDAO.php");

	class WorkshopsAction extends CommonAction {
		public $workshops_list;

		private $member_workshops;
		public $completed;
		public $new;
		public $Inprogress;
		public $notStarted;
		public $recommandations;
		public $workshop;
		public $show_workshop;
		public $questions;

		public $workshopStates;
		public $grades;

		public $robots;
		public $difficulty;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"workshops","Workshops");
			$this->show_workshop = false;
			$this->completed = [];
			$this->new = [];
			$this->inProgress = [];
			$this->notStarted = [];
			$this->recommandations = [];
		}

		protected function executeAction() {
			$this->complete_name = $this->trans->read("main","workshops");
			$this->workshops_list = WorkshopDAO::getWorkshops();

			$this->robots = RobotDAO::GetRobots();

			if($_SESSION["language"] == "en")
			{
				$this->difficulty = WorkshopDAO::getDifficultiesEN();
				$this->workshopStates = WorkshopDAO::getWorkshopStatesEN();
				$this->grades = WorkshopDAO::getGradesEN();
			}
			else
			{
				$this->difficulty = WorkshopDAO::getDifficultiesFR();
				$this->workshopStates = WorkshopDAO::getWorkshopStatesFR();
				$this->grades = WorkshopDAO::getGradesFR();
			}

		}
	}