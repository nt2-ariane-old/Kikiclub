<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");

	class RobotInfosAction extends CommonAction {

		public $exist;
		public $added;
		public $robot;

		public $add;
		public $update;

		public $grades;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'robot-infos','Robot Informations');
			$this->exist = false;
			$this->added = false;
			$this->add = false;
			$this->update = false;
		}

		protected function executeAction() {

			if(!empty($_GET["robot_id"]))
			{
				$_SESSION["robot_id"] = $_GET["robot_id"];
			}
			if(!empty($_SESSION["robot_id"]))
			{
				$this->exist = true;
				if($this->admin_mode)
				{
					$this->update = true;
				}
			}
			else
			{
				if($this->admin_mode)
				{
					$this->add = true;
				}
			}

			if($this->exist) $id = $_SESSION["robot_id"];

			if($_SESSION["language"] == 'en')
			{
				$this->grades = WorkshopDAO::getGradesEN();
			}
			else
			{
				$this->grades = WorkshopDAO::getGradesFR();
			}
			if($this->admin_mode)
			{
				if(isset($_POST['push']))
				{
					if($this->exist)
					{
						if(isset($_POST['push']))
						{
							if( !empty($_POST["name"]) &&
							!empty($_POST["grade_recommanded"]))
							{
								RobotDAO::updateRobot($id,$_POST["name"],$_POST["grade_recommanded"]);
								foreach ($this->difficulties as $difficulty) {
									RobotDAO::updateRobotScoreByDifficulty($id,$difficulty["ID"],intval($_POST["score_" . $difficulty["ID"]]));
								}
							}
							header('location:robots.php');
						}
						if(isset($_POST["delete"]))
						{
							RobotDAO::deleteRobot($id);;
						}
					}
					else
					{
						if(isset($_POST['push']))
						{
							RobotDAO::insertRobot($_POST["name"],$_POST["grade_recommanded"]);
							$newRobot = RobotDAO::getRobotByName($_POST["name"]);
							foreach ($this->difficulties as $difficulty) {
								RobotDAO::insertRobotScoreByDifficulty($newRobot["ID"],$difficulty["ID"],intval($_POST["score_" . $difficulty["ID"]]));
							}
							header('location:robots.php');
						}

					}

				}
				if(isset($_POST['delete']))
				{
					if($this->exist)
					{
						RobotDAO::deleteRobot($id);
						header('location:robots.php');
					}
				}
			}

			if($this->exist)
			{
				$this->robot = RobotDAO::getRobotsAndDifficultiesByID($id);
			}

		}
	}