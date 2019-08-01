<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberWorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/FilterDAO.php");
	class WorkshopInfosAction extends CommonAction {

		public $workshop;
		public $member_workshops;

		public $difficulties;
		public $workshop_difficulties;
		public $workshop_robots;
		public $workshop_grades;
		public $grades;
		public $robots;
		public $exist;
		public $added;
		public $filters;
		public $id_types;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"workshop-infos", "Workshop Information");
			$this->exist = false;
			$this->added = false;
		}

		protected function executeAction() {
			if(!empty($_GET["workshop_id"]))
			{
				$_SESSION["workshop_id"] = $_GET["workshop_id"];
			}
			if(!empty($_SESSION["workshop_id"]))
			{
				$this->exist = true;
			}

			if($_SESSION["language"] == 'en')
			{
				$this->difficulties = FilterDAO::getDifficultiesEN();
				$this->grades = FilterDAO::getGradesEN();
			}
			else
			{
				$this->difficulties = FilterDAO::getDifficultiesFR();
				$this->grades = FilterDAO::getGradesFR();

			}
			$this->robots = RobotDAO::getRobots(true);

			if($this->exist) $id = $_SESSION["workshop_id"];

			$this->id_types["robots"] = FilterDAO::getFilterTypeIdByName('robot');
			$this->id_types["difficulties"] = FilterDAO::getFilterTypeIdByName('difficulty');
			$this->id_types["grades"] = FilterDAO::getFilterTypeIdByName('grade');

			if($this->admin_mode)
			{
				if(isset($_POST['push']))
				{

					if($this->exist)
					{
						WorkshopDAO::updateWorkshop($id,$_POST['name'],$_POST['content'],$_POST['media_path'],$_POST['media_type']);

					}
					else
					{
						$deploy = false;
						if($_POST["deployed"] == 'true')
						{
							$deploy = true;
						}
						WorkshopDAO::addWorkshop($_POST['name'],$_POST['content'],	$_POST['media_path'], $_POST['media_type'],$deploy);
						$id = WorkshopDAO::getWorkshopByNameAndContent($_POST['name'],$_POST['content'])["id"];
						$this->added = true;
						$this->exist = true;
					}

					$this->filters = FilterDAO::getWorkshopFilters($id);

					$filters_selected = [];
					$filters_selected["robots"] = [];
					$filters_selected["difficulties"] = [];
					$filters_selected["grades"] = [];



					if(!empty($_POST["robots"]))
					{
						$filters_selected["robots"] = $_POST["robots"];
					}
					if(!empty($_POST["difficulties"]))
					{
						$filters_selected["difficulties"] = $_POST["difficulties"];
					}
					if(!empty($_POST["grades"]))
					{
						$filters_selected["grades"] = $_POST["grades"];
					}

					foreach ($filters_selected as $key => $list) {
						echo '<script> console.log(' . json_encode($list).') </script>';
						$id_type = $this->id_types[$key];
						foreach ($list as $value) {
							$id_filter = $this->getFilterID($id_type,$value);
							if($id_filter >= 0)
							{
								FilterDAO::updateWorkshopFilters($id_filter,$id,$id_type,$value);
							}
							else
							{
								FilterDAO::insertWorkshopFilters($id,$id_type,$value);

							}
						}

						$this->deleteOther($list,$id_type);

					}


				}
				if(isset($_POST['delete']))
				{
					if($this->exist)
					{
						WorkshopDAO::deleteWorkshop($id);
						header('location:workshops.php');
					}
				}
			}


			if($this->exist)
			{
				$this->filters = FilterDAO::getWorkshopFilters($id);

				$this->workshop = WorkshopDAO::getWorkshop($id);

				if(!empty($this->filters[$this->id_types["difficulties"]]))
				{
					$this->workshop_difficulties = $this->filters[$this->id_types["difficulties"]];
				}
				if(!empty($this->filters[$this->id_types["robots"]]))
				{
					$robots = $this->filters[$this->id_types["robots"]];
					foreach ($robots as $robot) {
						$this->workshop_robots[] = RobotDAO::getRobotByID($robot["id_filter"]);
					}
				}
				if(!empty($this->filters[$this->id_types["grades"]]))
				{
					$grades = $this->filters[$this->id_types["grades"]];
					foreach ($grades as $grade) {
						$this->workshop_grades[] = FilterDAO::getGradeById($grade["id_filter"]);
					}
				}
			}



		}

		public function getFilterID($id_type,$id_filter)
		{
			$id = -1;

			if(!empty($this->filters[$id_type]))
			{
				$list = $this->filters[$id_type];
				if(!empty($list))
				{
					if(array_key_exists($id_filter,$list))
					{
						$id = $list[$id_filter]["id"];
					}
				}
			}
			return $id;
		}
		public function deleteOther($list,$id_type)
		{
			if(!empty($this->filters[$id_type]))
			{

				foreach ($this->filters[$id_type] as $key => $filter)
				{
					if(!in_array($key,$list))
					{
							FilterDAO::deleteWorkshopFilters($filter["id"]);
					}
				}
			}

		}

	}