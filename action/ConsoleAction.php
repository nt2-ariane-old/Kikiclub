<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersDAO.php");

	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/FilterDAO.php");

	class ConsoleAction extends CommonAction {

		public $genders;
		public $avatars;
		public $difficulties;
		public $robots;
		public $grades;

		public $show_results;
		public $results;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"console", "Randomizer");
			$this->show_results = false;
		}

		protected function auto_generate_users($nb)
		{
			for ($i=0; $i < $nb; $i++) {
				$firstname = $this->generateString(16);
				$lastname = $this->generateString(16);
				$email = $this->generateString(10) . "@test.com";
				UsersDAO::registerUser($email,null,null,$firstname,$lastname,CommonAction::$VISIBILITY_CUSTOMER_USER,null);
			}
		}

		protected function auto_generate_workshops($nb)
		{
		 	for ($i=0; $i < $nb; $i++) {
		 		$name = $this->generateString(16);
				$content = $this->generateString(100);

				$grade = $this->grades[rand(0,sizeof($this->grades) -1)]["ID"];
				$diff = $this->difficulties[rand(0,sizeof($this->difficulties) -1 )]["ID"];
				$robot = $this->robots[rand(0,sizeof($this->robots) - 1) ]["ID"];
				$media_path = "images/uploads/workshops/logoNom.png";
				$media_type = "png";
				$deployed = rand(0,1);
		 		WorkshopDAO::addWorkshop($name, $content, $media_path, $media_type,$diff,$robot,$grade);
			}
		}

		protected function auto_generate_robots($nb)
		{
		 	for ($i=0; $i < $nb; $i++) {
				 $name = $this->generateString(8);

				 $grade = $this->grades[rand(0,sizeof($this->grades) -1)]["ID"];
				 RobotDAO::insertRobot($name,$grade);
				 $id = RobotDAO::getRobotByName($name)["ID"];
					$score = rand(1,20);
				 foreach ($this->difficulties as $diff) {
					 RobotDAO::insertRobotScoreByDifficulty($id,$diff["ID"],$score);
					 $score += rand(1,5);

				 }

			}
			$this->robots = RobotDAO::getRobots();

		}
		protected function generateString($nb)
		{
		  $final_string = "";

		  $range = "abcdefghijklmnopqrstuvwxyz -";
		  $length = strlen($range);

		  for ($i = 0; $i < $nb; $i++)
		  {
			$index = rand(0, $length - 1);
			$final_string.=$range[$index];
		  }

		  return $final_string;
		}
		protected function executeAction()
		{
			$this->grades = FilterDAO::getGradesFR();
			$this->difficulties = FilterDAO::getDifficultiesFR();
			$this->robots = RobotDAO::getRobots();

			if(!empty($_POST["value"]))
			{
				$nb = intval($_POST["value"]);
				if(!empty($_POST["robot"]))
				{
					$this->auto_generate_robots($nb);
					$this->results = $nb . " robots ont été créers aléatoirement";
				}
				if(!empty($_POST["user"]))
				{
					$this->auto_generate_users($nb);
					$this->results = $nb . " utilisateurs ont été créers aléatoirement";
				}
				if(!empty($_POST["workshop"]))
				{
					$this->auto_generate_workshops($nb);
					$this->results = $nb . " Ateliers ont été créers aléatoirement";
				}
				$this->show_results = true;
			}

		}

	}
