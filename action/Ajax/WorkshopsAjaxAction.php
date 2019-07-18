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
				if(!empty($_SESSION["member"]))
				{
					$this->results["member_workshops"] = WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
				}
			}

			if(!empty($_POST["id"]))
			{
				$this->results["workshop"] = WorkshopDAO::selectWorkshop($_POST["id"]);
				$this->results["robots"] = RobotDao::getRobots();

			}
			if(!empty($_POST["sort"]))
			{
				switch ($_POST["sort"]) {
					case 'none':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("none",false,true);
						break;
					case 'ascName':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("NAME",true,true);
						break;
					case 'descName':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("NAME",false,true);
						break;
					case 'recents':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("ID",true,true);
						break;
				}
			}
			if(!empty($_POST["search"]))
			{
				if(!empty($_POST["difficulties"]))
				{
					$difficulties = json_decode($_POST["difficulties"],true);
					if(sizeof($difficulties) > 0)
					{
						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							foreach ($difficulties as $difficulty_id)
							{
								if($difficulty_id === $workshop["ID_DIFFICULTY"])
								{
									$temp[] = $workshop;
								}
							}
						}


						$this->results["workshops"] = $temp;
					}
				}
				if(!empty($_POST["grades"]))
				{
					$grades = json_decode($_POST["grades"],true);
					if(sizeof($grades) > 0)
					{
						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							foreach ($grades as $grade_id)
							{
								if($grade_id === $workshop["ID_GRADE"])
								{
									$temp[] = $workshop;
								}
							}
						}


						$this->results["workshops"] = $temp;
					}
				}
				if(!empty($_POST["states"]))
				{

					$states = json_decode($_POST["states"]);
					if(!empty($_SESSION["member"]))
					{
					$has_new = false;
					if(sizeof($states) > 0)
					{
						$temp = [];

						$member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
						$new_workshops =WorkshopDAO::selectMemberNewWorkshop($_SESSION["member"]);
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



					}
						$this->results["workshops"] = $temp;
					}
				}
				}
				if(!empty($_POST["robots"]))
				{
					$robots = json_decode($_POST["robots"]);

					if(sizeof($robots) > 0)
					{
						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							foreach ($robots as $robot_id)
							{

									if($robot_id == $workshop["ID_ROBOT"])
									{
										$temp[] = $workshop;
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
				$this->results["workshop"] = WorkshopDAO::selectWorkshop($_POST["id"]);
			}
		}
	}