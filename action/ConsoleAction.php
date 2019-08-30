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
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"console");
			$this->show_results = false;
		}

		protected function auto_generate_users($nb)
		{
			for ($i=0; $i < $nb; $i++) {
				$firstname = $this->generateString(16);
				$lastname = $this->generateString(16);
				$email = $this->generateString(10) . "@test.com";
				$token = $this->generateString(8);
				UsersDAO::registerUser($email,null,null,$firstname,$lastname,CommonAction::$VISIBILITY_CUSTOMER_USER,null,$token);
			}
		}

		protected function random_birthday()
		{
			$datestart = strtotime('2000-12-10');//you can change it to your timestamp;
			$dateend = strtotime('2014-12-31');//you can change it to your timestamp;

			$daystep = 86400;

			$datebetween = abs(($dateend - $datestart) / $daystep);

			$randomday = rand(0, $datebetween);

			return date("d/m/Y", $datestart + ($randomday * $daystep)) . "\n";
		}
		protected function auto_generate_members($nb)
		{
			$user = UsersDAO::getAllUsers();
			$avatar = MemberDAO::loadAvatar();
			$genders = MemberDAO::getGenders($_SESSION["language"] == 'fr');
			for ($i=0; $i < $nb; $i++) {
				$firstname = $this->generateString(16);
				$lastname = $this->generateString(16);
				$birthday = $this->random_birthday();
				$gender = $genders[rand(0,sizeof($genders) -1)]["id"];
				$id_avatar = $avatar[rand(0,sizeof($avatar) -1)]["id"];
				$id_parent = $user[rand(0,sizeof($user) -1)]["id"];
				MemberDAO::insertMember($firstname,$lastname,$birthday,$gender,$id_avatar,$id_parent);
			}
		}

		protected function auto_generate_workshops($nb)
		{
		 	for ($i=0; $i < $nb; $i++) {
		 		$name = $this->generateString(16);
				$content = $this->generateString(100);

				$grade = $this->grades[rand(0,sizeof($this->grades) -1)]["id"];
				$diff = $this->difficulties[rand(0,sizeof($this->difficulties) -1 )]["id"];
				$robot = $this->robots[rand(0,sizeof($this->robots) - 1) ]["id"];
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

				 $grade = $this->grades[rand(0,sizeof($this->grades) -1)]["id"];
				//  RobotDAO::insertRobot($name,$grade);
				 $id = RobotDAO::getRobotByName($name)["id"];
					$score = rand(1,20);
				 foreach ($this->difficulties as $diff) {
					 RobotDAO::insertRobotScoreByDifficulty($id,$diff["id"],$score);
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
				if(isset($_POST["robot"]))
				{
					$this->auto_generate_robots($nb);
					$this->results = $nb . " robots ont été créers aléatoirement";
				}
				if(isset($_POST["user"]))
				{
					$this->auto_generate_users($nb);
					$this->results = $nb . " utilisateurs ont été créers aléatoirement";
				}
				if(isset($_POST["member"]))
				{
					$this->auto_generate_members($nb);
					$this->results = $nb . " membres ont été créers aléatoirement";
				}
				if(isset($_POST["workshop"]))
				{
					$this->auto_generate_workshops($nb);
					$this->results = $nb . " Ateliers ont été créers aléatoirement";
				}
				$this->show_results = true;
			}

		}

	}
