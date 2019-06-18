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

		public $robots;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"Workshops");
			$this->show_workshop = false;
			$this->completed = [];
			$this->new = [];
			$this->inProgress = [];
			$this->notStarted = [];
			$this->recommandations = [];
		}
		private function checkRecommandations()
		{
			$this->recommandations =array_merge($this->notStarted,$this->new);
			$this->recommandations = array_merge($this->recommandations,$this->inProgress);
		}
		protected function executeAction() {
			$this->workshops_list = WorkshopDAO::getWorkshops();
			$this->robots = RobotDAO::GetRobots();
			if(!empty($_SESSION["member"]))
			{
				$this->member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
				foreach ($this->workshops_list as $workshop) {
					foreach ($this->member_workshops as $memberWorkshop) {
						if($workshop["ID"] == $memberWorkshop["ID_WORKSHOP"])
						{
							switch ($memberWorkshop["STATUT"]) {
								case 0:
									$this->notStarted[] = $workshop;
									break;
								case 1:
									$this->inProgress[] = $workshop;
									break;

								case 2:
									$this->completed[] = $workshop;
									break;
							}
						}
					}
				}
				$this->new = WorkshopDAO::selectMemberNewWorkshop($_SESSION["member"]);
				if(!empty($_GET["workshop"]))
				{
					$id = intval($_GET["workshop"]);
					$this->show_workshop = true;
					$this->workshop = WorkshopDAO::selectWorkshop($id);
					$this->questions = WorkshopDAO::selectWorkshopQuestions($id);
					foreach ($this->new as $item) {
						if($id == $item["ID"])
						{
							WorkshopDAO::addMemberWorkshop($_SESSION["member"],$id,0);
						}

					}


				}
			}
			else
			{
				header('Location:users.php');
			}
			$this->checkRecommandations();

		}
	}