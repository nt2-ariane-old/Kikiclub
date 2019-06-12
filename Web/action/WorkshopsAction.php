<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	class WorkshopsAction extends CommonAction {
		public $workshops_list;

		public $workshop;
		public $show_workshop;
		public $questions;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"Workshops");
			$this->show_workshop = false;
		}

		protected function executeAction() {
			$this->workshops_list = WorkshopDAO::getWorkshops();
			if(!empty($_GET["workshop"]))
			{
				$id = intval($_GET["workshop"]);
				$this->show_workshop = true;
				$this->workshop = WorkshopDAO::selectWorkshop($id);
				$this->questions = WorkshopDAO::selectWorkshopQuestions($id);
			}
		}
	}