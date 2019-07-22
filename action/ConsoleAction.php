<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/FamilyDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/RobotDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/BadgeDAO.php");

	class ConsoleAction extends CommonAction {
		//liste d'objets et objet individuel a modifier
		public $workshops;
		public $workshopMod;

		public $users;
		public $members;
		public $all_searched;

		public $userMod;
		public $genders;
		public $family;
		public $familyMod;
		public $familyWorkshops;

		public $robotMod;

		public $avatars;

		public $difficulties;
		public $robots;
		//differentes fonctions d'administrations (true si utiliser, false si non)
		public $update;
		public $add;
		public $addFamily;
		public $modFamily;
		public $assignFamily;


		public $workshopAdded;


		//Page en cours
		public $pageWorkshops;
		public $pageUsers;
		public $pageRobots;

		//Error infos
		public $error;
		public $errorMsg;

		public $grades;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"console", "Admin Console");
			$this->add = false;
			$this->update=false;

			$this->addFamily=false;
			$this->modFamily=false;
			$this->assignFamily=false;

			$this->pageWorkshops=false;
			$this->pageUsers=false;

			$this->error = false;
			$this->workshopAdded = false;
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
			$this->grades = WorkshopDAO::getGradesFR();
			$this->difficulties = WorkshoPDAO::getDifficultiesFR();
			$this->robots = RobotDAO::getRobots();
			if(!empty($_GET["generate"]))
			{
				$gen = $_GET["generate"];
				if(!empty($_GET["nb"]))
				{
					$nb = intval($_GET["nb"]);
					if($gen == "robots")
					{
						$this->auto_generate_robots($nb);
					}
					if($gen == "users")
					{
						$this->auto_generate_users($nb);
					}
					if($gen == "workshops")
					{
						$this->auto_generate_workshops($nb);
					}
				}

			}
		}

	}
