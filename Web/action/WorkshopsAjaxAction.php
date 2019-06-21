<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/RobotDAO.php");
	class WorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_FAMILY_MEMBER,"workshops-ajax","Workshops,Ajax");
		}

		protected function executeAction() {

			if(!empty($_SESSION["member"]))
			{
				$this->results["member_workshops"] = WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
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
						$this->results["workshops"]=WorkshopDAO::getWorkshops();
						break;
					case 'ascName':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("NAME",true);
						break;
					case 'descName':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("NAME",false);
						break;
					case 'recents':
						$this->results["workshops"]=WorkshopDAO::getWorkshops("ID");
						break;
				}
			}
			if(!empty($_POST["search"]))
			{
				$this->results["workshops"] = WorkshopDAO::searchWorkshops();
				if(!empty($_POST["difficulty"]))
				{
					$difficulties = json_decode($_POST["difficulty"]);
					if(sizeof($difficulties) > 0)
					{
						$temp = [];
						foreach ($this->results["workshops"] as $workshop)
						{
							foreach ($difficulties as $difficulty_id)
							{
									if($difficulty_id == $workshop["ID_DIFFICULTY"])
									{
										$temp[] = $workshop;
									}
							}
						}
						$this->results["workshops"] = $temp;
					}
				}
				if(!empty($_POST["state"]))
				{
					$states = json_decode($_POST["state"]);


					if(sizeof($states) > 0)
					{
						$temp = [];
						foreach ($states as $state)
						{

							if(!empty($_SESSION["member"]))
							{
								$member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member"]);
								$new_workshops =WorkshopDAO::selectMemberNewWorkshop($_SESSION["member"]);
								foreach ($this->results["workshops"] as $workshop) {
									if($state == -1)
									{
										foreach ($new_workshops as $n_workshop) {
											if($n_workshop["ID"] == $workshop["ID"])
											{
												$temp[] = $workshop;
											}
										}
									}
									else
									{
										foreach ($member_workshops as $m_workshop) {
											if($m_workshop["ID_WORKSHOP"] == $workshop["ID"] &&
												$state == $m_workshop["STATUT"])
											{
												$temp[] = $workshop;
											}
										}
									}
								}
							}
						}
						$this->results["workshops"] = $temp;
					}
				}
				if(!empty($_POST["robot"]))
				{
					$robots = json_decode($_POST["robot"]);

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
		}
	}