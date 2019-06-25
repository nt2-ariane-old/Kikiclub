<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	class WorkshopInfosAction extends CommonAction {

		public $workshop;
		public $member_workshops;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"workshop-infos", "Workshop Information");
		}

		protected function executeAction() {
			$this->member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);

			if(!empty($_GET["workshop"]))
			{
				$id = intval($_GET["workshop"]);

				$this->workshop = WorkshopDAO::selectWorkshop($id);
				$this->show_workshop = true;
				$this->questions = WorkshopDAO::selectWorkshopQuestions($id);

				$existe = false;
				foreach ($this->member_workshops as $item) {
					if($id == $item["ID_WORKSHOP"])
					{
							$existe = true;
							break;
					}
				}
				if(!$existe)
				{
					WorkshopDAO::addMemberWorkshop($_SESSION["member"],$id,0);
				}
			}
		}
	}