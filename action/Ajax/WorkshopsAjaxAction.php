<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	class WorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"workshops-ajax","Workshops,Ajax");
		}

		protected function executeAction() {
			if($_SESSION["language"] == 'en')
			{
				$this->results["states"] = WorkshopDAO::getWorkshopStatesEN();
			}
			else
			{
				$this->results["states"] = WorkshopDAO::getWorkshopStatesFR();
			}
			if(!empty($_SESSION["id"]))
			{
				if(!empty($_SESSION["member_id"]))
				{
					$this->results["workshops"] = WorkshopDAO::selectMemberWorkshop($_SESSION["member_id"]);
				}
			}
			if(!empty($_POST["id"]))
			{
				$this->results["workshop"] = WorkshopDAO::getWorkshop($_POST["id"]);
				$this->results["robots"] = RobotDao::getRobots();
			}
			if(!empty($_POST["selected"]))
			{
				$selected = json_decode($_POST["selected"],true);
				foreach ($selected as $value) {
					if(!empty($_POST["deployed_multiple"]))
					{
						$deployed = WorkshopDAO::isDeployed($value);
						if($deployed)
						{
							WorkshopDAO::setDeployed($value,"false");
							$this->results["undeployed"][] = $value;
						}
						else
						{
							WorkshopDAO::setDeployed($value,"true");
							$this->results["has_been_deployed"][] = $value;

						}
					}
					else if (!empty($_POST["delete_multiple"]))
					{
						WorkshopDAO::deleteWorkshop($value);
					}
					# code...
				}

			}
			if(!empty($_POST["sort"]))
			{
				$f = null;
				if($this->admin_mode || empty($_SESSION["member_id"]))
				{
					$f = "WorkshopDAO::getWorkshops";
					$id = null;
				}
				else
				{
					$f = "WorkshopDAO::getMemberWorkshopsSorted";
					$id = $_SESSION["member_id"];
				}
				switch ($_POST["sort"]) {
					case 'none':
						$this->results["workshops"]=$f($id,"none",false,!$this->admin_mode);
					break;
					case 'ascName':
						$this->results["workshops"]=$f($id,"NAME",true,!$this->admin_mode);
						break;
					case 'descName':
					$this->results["workshops"]=$f($id,"NAME",false,!$this->admin_mode);
					break;
					case 'recents':
					$this->results["workshops"]=$f($id,"ID",true,!$this->admin_mode);
					break;
				}
			}
			if(!empty($_POST["search"]))
			{
				if(!empty($_POST["difficulties"]))
				{
					$this->results["search"]["difficulties"] = $_POST["difficulties"];
					$difficulties = json_decode($_POST["difficulties"],true);
					if(sizeof($difficulties) > 0)
					{
						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							$filters = WorkshopDAO::getWorkshopFilters($workshop["ID"]);
							$workshop_difficulties = $filters[WorkshopDAO::getFilterTypeIdByName('difficulty')];
							if(!empty($workshop_difficulties))
							{
								foreach ($difficulties as $difficulty_id)
								{
									foreach ($workshop_difficulties as $diff) {
										if($difficulty_id === $diff["id_filter"])
										{
											$temp[] = $workshop;
										}
									}
								}
							}
						}
						$this->results["workshops"] = $temp;
					}
				}
				if(!empty($_POST["grades"]))
				{
					$this->results["search"]["grades"] = $_POST["grades"];
					$grades = json_decode($_POST["grades"],true);
					if(sizeof($grades) > 0)
					{
						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							$filters = WorkshopDAO::getWorkshopFilters($workshop["ID"]);
							$workshop_grades = $filters[WorkshopDAO::getFilterTypeIdByName('grade')];
							if(!empty($workshop_grades ))
							{
								foreach ($grades as $grade_id)
								{
									foreach ($workshop_grades as $grade) {
										if($grade_id === $grade["id_filter"])
										{
											$temp[] = $workshop;
										}
									}
								}
							}
						}
						$this->results["workshops"] = $temp;
					}
				}
				if(!empty($_POST["states"]))
				{
					$this->results["search"]["states"] = $_POST["states"];

					$states = json_decode($_POST["states"]);
					if(!empty($_SESSION["member_id"]))
					{
					$has_new = false;
					if(sizeof($states) > 0)
					{
						$temp = [];
						$member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member_id"]);
						$new_workshops =WorkshopDAO::selectMemberNewWorkshop($_SESSION["member_id"]);
						foreach ($states as $state)
						{
							foreach ($this->results["workshops"] as $workshop)
							{
								foreach ($member_workshops as $m_workshop)
								{
									if($m_workshop["ID_WORKSHOP"] == $workshop["ID"] &&
										$state == $m_workshop["ID_STATUT"])
									{
										$temp[] = $workshop;
									}

								}
								foreach ($new_workshops as $m_workshop)
								{

									if($workshop["ID"] == $m_workshop["ID"] )
									{
										if($state == 1 || $state == 2)
										{
											$temp[] = $workshop;
										}
									}

								}
							}
							$this->results["workshops"] = $temp;
						}
					}
				}
				}
				if(!empty($_POST["robots"]))
				{
					$this->results["search"]["robots"] = $_POST["robots"];

					$robots = json_decode($_POST["robots"]);

					if(sizeof($robots) > 0)
					{						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							$filters = WorkshopDAO::getWorkshopFilters($workshop["ID"]);
							var_dump($filters);
							if(!empty($filters[WorkshopDAO::getFilterTypeIdByName('robot')]))
							{
								$workshop_robots = $filters[WorkshopDAO::getFilterTypeIdByName('robot')];

								foreach ($robots as $robot_id)
								{
									foreach ($workshop_robots as $robot) {
										if($robot_id === $robot["id_filter"])
										{
											$temp[] = $workshop;
										}
									}
								}
							}
						}
						$this->results["workshops"] = $temp;
					}
				}



			}
			if(!empty($_POST["deployed"]))
			{
				WorkshopDAO::setDeployed($_POST["id"],$_POST["deployed"]);
				$this->results = [];
				$this->results["state"] = $_POST["deployed"];
				$this->results["type"] = "deployed";
				$this->results["workshop"] = WorkshopDAO::getWorkshop($_POST["id"]);


			}
			if(!empty($this->results["workshops"]))
			{
				$this->results["nbPages"] = ceil(sizeof($this->results["workshops"]) /12);
			}
			else
			{
				$this->results["nbPages"] = 0;
			}
			if(isset($_POST["page"]))
			{
				$page = $_POST["page"];
				if($page == -1)
				{
					$page = 0;
				}
				else if($page >= $this->results["nbPages"])
				{
					$page = $this->results["nbPages"] - 1;
				}
				$limit_min = $page * 12;
				$limit_max = 12;
				$this->results["workshops"] = array_slice($this->results["workshops"],$limit_min,$limit_max);

			}
			if(isset($_POST["assign-all"]))
			{
				$id = $_SESSION["workshop_id"];
				$filters = WorkshopDAO::getWorkshopFilters($id);
				$grades = $filters[WorkshopDAO::getFilterTypeIdByName('grade')];


				$ages = [];
				if(!empty($grades))
				{
					foreach ($grades as $grade) {
						$id_grade = $grade["id_filter"];

						$ages[] = WorkshopDAO::getGradeById($id_grade)["AGE"];
					}
				}
				$members = FamilyDAO::getAllMemberWithAges($ages);
				var_dump($members);
				$this->results = [];
				foreach ($members as $value) {
					$id_member = $value["ID"];
					$workshops = WorkshopDAO::selectMemberWorkshop($id_member);
					if(!array_key_exists($id,$workshops))
					{
						WorkshopDAO::addMemberWorkshop($id_member,$id, 1);
						$this->results[] = $value;

					}

				}

			}
		}
	}