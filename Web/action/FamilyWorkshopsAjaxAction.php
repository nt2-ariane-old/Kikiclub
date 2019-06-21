<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");

	class FamilyWorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'familyWorkshops-ajax', "Family Workshops, Ajax");
			$this->results = 'invalide';
		}

		protected function executeAction() {
			if(!empty($_POST["id_workshop"]) &&
			!empty($_POST["category"]) &&
			!empty($_POST["adding"]))
			{
				if($_POST["adding"] == true)
				{
					$workshops = WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
					$statut;
					switch ($_POST["category"]) {
						case 'not-started':
							$statut = 0;
							break;
						case 'in-progress':
							$statut = 1;
							break;
						case 'complete':
							$statut = 2;
							break;
						default:
							$statut = 0;
							break;
					}

					if(!empty($workshops[intval($_POST["id_workshop"])]))
					{
						WorkshopDAO::updateMemberWorkshop($_SESSION["member"],intval($_POST["id_workshop"]), $statut);
					}
					else
					{
						WorkshopDAO::addMemberWorkshop($_SESSION["member"],intval($_POST["id_workshop"]), $statut);
					}
					$this->results = 'valide';
				}

			}
		}
	}