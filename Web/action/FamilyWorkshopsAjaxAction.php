<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/FamilyDAO.php");
	require_once("action/DAO/RobotDAO.php");
	require_once("action/DAO/BadgeDAO.php");
	class FamilyWorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'familyWorkshops-ajax', "Family Workshops, Ajax");
			$this->results = 'invalide';
		}

		protected function executeAction() {
			$id_member =$_SESSION["member_admin"];
			if(!empty($_POST["id_workshop"]) &&
			!empty($_POST["category"]) &&
			!empty($_POST["adding"]))
			{
				if($_POST["adding"] == true)
				{
					$workshops = WorkshopDAO::selectMemberWorkshop($id_member);

					$statut;
					switch ($_POST["category"]) {
						case 'new':
							$statut = 1;
								break;
						case 'not-started':
							$statut = 2;
							break;
						case 'in-progress':
							$statut = 3;
							break;
						case 'complete':
							$statut = 4;
							break;

						default:
							$statut = 1;
							break;
					}
					if(!empty($workshops[intval($_POST["id_workshop"])]))
					{
						WorkshopDAO::updateMemberWorkshop($id_member,intval($_POST["id_workshop"]), $statut);
					}
					else
					{
						WorkshopDAO::addMemberWorkshop($id_member,intval($_POST["id_workshop"]), $statut);
					}

					$workshops = WorkshopDAO::selectMemberWorkshop($id_member);
					if($statut == 4)
					{

						$workshop = WorkshopDAO::getWorkshopsWithID(intval($_POST["id_workshop"]));
						$score = RobotDAO::getScoreOfRobotByDifficulty($workshop["ID_ROBOT"],$workshop["ID_DIFFICULTY"]);
						FamilyDAO::addScore($id_member,$score);

						$member = FamilyDAO::selectMember($id_member);
						$member_badges = BadgeDAO::getMemberBadge($id_member);
						$badges = BadgeDAO::getBadges(1);


						$this->results = 'valide';
						foreach ($badges as $badge) {

							if($member["score"] >= $badge["VALUE_NEEDED"] )
							{
								if(!array_key_exists($badge["ID"],$member_badges))
								{
									$this->results = $member["firstname"] . " just won the " . $badge["NAME"] . " badge";
									BadgeDAO::addBadgeToMember($badge["ID"],$member["ID"],$member["id_user"]);
								}
								else
								{
									$this->results = $member["firstname"] . " already have the " . $badge["NAME"] . " badge";
								}
							}
						}
					}



				}

			}
		}
	}