<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberWorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/BadgeDAO.php");
	class MemberWorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'familyWorkshops-ajax', "Family Workshops, Ajax");
			$this->results = 'invalide';
		}

		protected function executeAction() {
			$id_member =$_SESSION["member_id"];
			if(!empty($_POST["id_workshop"]) &&
			!empty($_POST["category"]) &&
			!empty($_POST["adding"]))
			{
				if($_POST["adding"] == true)
				{
					$workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);

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
						MemberWorkshopDAO::updateMemberWorkshop($id_member,intval($_POST["id_workshop"]), $statut);
					}
					else
					{
						MemberWorkshopDAO::addMemberWorkshop($id_member,intval($_POST["id_workshop"]), $statut);
					}

					$workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);
					if($statut == 4)
					{

						$workshop = WorkshopDAO::getWorkshop(intval($_POST["id_workshop"]));
						$filters = FilterDAO::getWorkshopFilters(intval($_POST["id_workshop"]));
						$difficulties = $filters[FilterDAO::getFilterTypeIdByName("difficulty")];
						$robots = $filters[FilterDAO::getFilterTypeIdByName("robot")];

						$score = 0;
						if(!empty($robots) || !empty($difficulties))
						{
							foreach ($robots as $robot) {
								foreach ($difficulties as $diff) {
									$score += RobotDAO::getScoreOfRobotByDifficulty($robot["id"],$diff["id"]);
									# code...
								}
							}
						}
						MemberDAO::addScore($id_member,$score);

						$member = MemberDAO::selectMember($id_member);
						$member_badges = BadgeDAO::getMemberBadge($id_member);
						$badges = BadgeDAO::getBadges(1);


						$this->results = 'valide';
						foreach ($badges as $badge) {

							if($member["score"] >= $badge["value_needed"] )
							{
								if(!array_key_exists($badge["id"],$member_badges))
								{
									$this->results = $member["firstname"] . " just won the " . $badge["name"] . " badge";
									BadgeDAO::addBadgeToMember($badge["id"],$member["id"],$member["id_user"]);
								}
								else
								{
									$this->results = $member["firstname"] . " already have the " . $badge["name"] . " badge";
								}
							}
						}
					}



				}

			}
		}
	}