<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberWorkshopDAO.php");

	class AssignMemberAction extends CommonAction {
		public $workshopsDeployed;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ANIMATOR,'assign-member');
		}

		protected function executeAction() {
			if(empty($_SESSION["member_id"]))
			{
				header("Location:" . $this->previous_page .".php");
			}

			$id_member = $_SESSION["member_id"];
			$this->workshops_deployed = WorkshopDAO::getWorkshops(null,"none",false,true);
			$this->member_workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);



		}
	}