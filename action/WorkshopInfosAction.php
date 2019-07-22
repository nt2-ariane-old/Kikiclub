<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	class WorkshopInfosAction extends CommonAction {

		public $workshop;
		public $member_workshops;

		public $difficulties;
		public $grades;
		public $robots;
		public $exist;
		public $added;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,"workshop-infos", "Workshop Information");
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


			if($this->exist) $id = $_SESSION["workshop_id"];

			if($this->admin_mode)
			{
				if(isset($_POST['push']))
				{

					if($this->exist)
					{
						WorkshopDAO::updateWorkshop($id,$_POST['name'],$_POST['content'],$_POST['media_path'],$_POST['media_type'],$_POST['difficulty'],$_POST['robot'],$_POST['grade']);
					}
					else
					{
						$deploy = false;
						if($_POST["deployed"] == 'true')
						{
							$deploy = true;
						}
						WorkshopDAO::addWorkshop($_POST['name'],$_POST['content'],	$_POST['media_path'], $_POST['media_type'],$_POST['difficulty'],$_POST['robot'],$_POST['grade'],$deploy);
						$this->added = true;
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

			if($_SESSION["language"] == 'en')
			{
				$this->difficulties = WorkshopDAO::getDifficultiesEN();
				$this->grades = WorkshopDAO::getGradesEN();
			}
			else
			{
				$this->difficulties = WorkshopDAO::getDifficultiesFR();
				$this->grades = WorkshopDAO::getGradesFR();

			}
			$this->robots = RobotDAO::getRobots();

			if($this->exist)
			{
				$this->workshop = WorkshopDAO::selectWorkshop($id);
				if(!empty($_SESSION["member_id"]))
				{
					$this->member_workshops =WorkshopDAO::selectMemberWorkshop($_SESSION["member_id"]);
					$existe = false;
					foreach ($this->member_workshops as $item)
					{
						if($id == $item["ID_WORKSHOP"])
						{
							$existe = true;
							break;
						}
					}
					if(!$existe)
					{
						WorkshopDAO::addMemberWorkshop($_SESSION["member_id"],$id,2);
					}
				}

			}



		}
	}