<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	class WorkshopsAction extends CommonAction {
		public $workshops_list;

		private $member_workshops;
		public $completed;
		public $new;
		public $Inprogress;
		public $notStarted;

		public $workshop;
		public $show_workshop;
		public $questions;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"Workshops");
			$this->show_workshop = false;
			$this->completed = [];
			$this->new = [];
			$this->inProgress = [];
			$this->notStarted = [];
		}

		protected function executeAction() {
			$this->workshops_list = WorkshopDAO::getWorkshops();
			if(!empty($_SESSION["member"]))
			{
				$this->member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
				foreach ($this->workshops_list as $workshop) {
					$existe = false;
					foreach ($this->member_workshops as $memberWorkshop) {
						if($workshop["ID"] == $memberWorkshop["ID_WORKSHOP"])
						{
							$existe = true;
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
					if($existe == false)
					{
						$this->new[] = $workshop;
					}
				}
			}
			else
			{
				header('Location:users.php');
			}
			if(!empty($_GET["workshop"]))
			{
				$id = intval($_GET["workshop"]);
				$this->show_workshop = true;
				$this->workshop = WorkshopDAO::selectWorkshop($id);
				$this->questions = WorkshopDAO::selectWorkshopQuestions($id);
			}
		}
	}