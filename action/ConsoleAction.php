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

			$this->preparePage();

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

			$this->checkAction();


		}

		//Prepare the page before doing action
		private function preparePage()
		{
			if(!empty($_SESSION["POST"]))
			{
				$_POST = $_SESSION["POST"];
				unset($_SESSION["POST"]);
			}

			$this->workshopsNotDeployed = WorkshopDAO::getWorkshops("none",false,false);
			$this->workshopsDeployed = WorkshopDAO::getWorkshops("none",false,true);

			$this->genders = FamilyDAO::getGenders();

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

			if(isset($_POST["users"]))
			{
				$_SESSION["users"] = true;
				unset($_SESSION['workshops']);
				unset($_SESSION['robots']);
			}
			else if (isset($_POST["workshops"]))
			{
				$_SESSION["workshops"] = true;
				unset($_SESSION['users']);
				unset($_SESSION['robots']);
			}
			else if(isset($_POST["robots"]))
			{
				$_SESSION["robots"] = true;
				unset($_SESSION['users']);
				unset($_SESSION['workshops']);
			}


			if(isset($_SESSION["users"]))
			{
				$this->pageUsers=true;
				$this->complete_name = "Users Management";
			}
			else if (isset($_SESSION["workshops"]))
			{
				$this->pageWorkshops=true;
				$this->complete_name = "Workshops Management";

			}
			else if(isset($_SESSION["robots"]))
			{
				$this->pageRobots = true;
				$this->complete_name = "Robots Management";

			}

			if(!empty($_POST["members_list"]))
			{
				$_SESSION["member_admin"] = $_POST["members_list"][0];
			}
		}

		//Verify what action to do with conditions
		private function checkAction()
		{
			if(isset($_POST['add']) && !isset($_POST['back']))
			{
				$this->add = true;
				if(isset($_POST['push']))
				{

					else if($this->pageUsers)
					{
						$this->addUser();
					}
					else if ($this->pageRobots)
					{
						$this->addRobot();
					}
				}
			}
			else if(isset($_POST['update']) && !isset($_POST['back']))
			{
				$this->update = true;

				if ($this->pageRobots)
				{
					$this->updateRobot();
				}
			}


			else if(isset($_POST['delete']))
			{
				else if($this->pageRobots)
				{
					$this->deleteRobots();
				}

			}

		}

		//All Possible Actions
		private function deleteWorkshops()
		{
			if(!empty($_POST['workshops_list']))
			{
				foreach($_POST['workshops_list'] as $workshop)
				{
					WorkshopDAO::deleteWorkshop($workshop);
				}
				header("Location:console.php");
			}
		}
		private function deployWorkshops()
		{
			$list = $_POST["workshops_list"];
			foreach ($list as $workshop) {
				WorkshopDAO::setDeployed($workshop,"true");
			}
		}
		private function deleteRobots()
		{
			if(!empty($_POST['robots_list']))
			{
				foreach ($_POST['robots_list'] as $robot) {
					RobotDAO::deleteRobot($robot);
				}
				header('location:console.php');
			}

		}
		private function deleteUsersAndMembers()
		{
			if(!empty($_POST['members_list']))
			{
				foreach($_POST['members_list'] as $members)
				{
					FamilyDAO::deleteFamilyMember($members);
				}
			}
			if(!empty($_POST['users_list']))
			{
				foreach($_POST['users_list'] as $user)
				{
					FamilyDAO::deleteUsers($user);
				}
			}
			header("Location:console.php");
		}
		private function updateUser()
		{

			if(!empty($_POST['users_list']))
			{
				$this->userMod = FamilyDAO::getUserFamily(intval($_POST['users_list'][0]));

				if(isset($_POST['push']))
				{
					UsersDAO::updateUser(intval($_POST['users_list'][0]),$_POST['email'],$_POST['firstname'],$_POST['lastname']);
					header('location:console.php');
				}
			}
		}

		private function updateMember()
		{

			$this->update = false;
			$this->modFamily = true;

			$this->familyMod = FamilyDAO::selectMember($_SESSION["admin_member_id"]);
			$this->avatars = FamilyDAO::loadAvatar();
			if(isset($_POST["form"]))
			{
				if( !empty($_POST["firstname"]) &&
					!empty($_POST["lastname"]) &&
					!empty($_POST["birth"]))
					{
						FamilyDAO::updateFamilyMember(intval($_POST['members_list'][0]),$_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"]);
						header('location:console.php');
					}
					else
					{
						$this->error=true;
						$this->errorMsg = "You need to fill all Feeld...";
					}
			}
			if(!empty($_GET["delete"]))
			{
				FamilyDAO::deleteFamilyMember(intval($_POST['members_list'][0]));

			}
		}

		private function updateWorkshop()
		{
			if(!empty($_POST['workshops_list']))
			{
				$this->workshopMod = WorkshopDAO::selectWorkshop(intval($_POST['workshops_list'][0]));
				if(isset($_POST['push']))
				{
					WorkshopDAO::updateWorkshop(intval($_POST['workshops_list'][0]),$_POST['name'],$_POST['content'],$_POST['media_path'],$_POST['media_type'],$_POST['difficulty'],$_POST['robot'],$_POST['grade']);
					header('location:console.php');
				}
			}
		}

		private function addRobot()
		{
			RobotDAO::insertRobot($_POST["name"],$_POST["grade_recommanded"]);
			$newRobot = RobotDAO::getRobotByName($_POST["name"]);
			foreach ($this->difficulties as $difficulty) {
				RobotDAO::insertRobotScoreByDifficulty($newRobot["ID"],$difficulty["ID"],intval($_POST["score_" . $difficulty["ID"]]));
			}
			header('location:console.php');

		}
		private function updateRobot()
		{
			if(!empty($_POST["robots_list"]))
			{

				$id = $_POST['robots_list'][0];
				$this->robotMod = RobotDAO::getRobotsAndDifficultiesByID(intval($id));
				if(isset($_POST['push']))
				{
					if( !empty($_POST["name"]) &&
					!empty($_POST["grade_recommanded"]))
					{
						RobotDAO::updateRobot($_POST['robots_list'][0],$_POST["name"],$_POST["grade_recommanded"]);
						foreach ($this->difficulties as $difficulty) {
							RobotDAO::updateRobotScoreByDifficulty($id,$difficulty["ID"],intval($_POST["score_" . $difficulty["ID"]]));
						}
					}
					header('location:console.php');

				}
			}
			else
			{
				header('location:console.php');
			}
		}
		private function addMember()
		{
			$this->userMod = $_POST['users_list'][0];
					$this->addFamily = true;
					$this->avatars = FamilyDAO::loadAvatar();
					if(isset($_POST["form"]))
					{
						if( !empty($_POST["firstname"]) &&
							!empty($_POST["lastname"]) &&
							!empty($_POST["birth"]))
							{
								FamilyDAO::insertFamilyMember($_POST["firstname"],$_POST["lastname"],$_POST["birth"],$_POST["gender"],$_POST["avatar"],$_POST['users_list'][0]);
								header('location:console.php');
							}
							else
							{
								$this->error=true;
								$this->errorMsg = "You need to fill all Feeld...";
							}
					}
		}

		private function addUser()
		{
			UsersDAO::registerUser($_POST['email'],null,null,$_POST['firstname'],$_POST['lastname'],CommonAction::$VISIBILITY_CUSTOMER_USER,null);
		}

		private function addWorkshop()
		{



			try {
				WorkshopDAO::addWorkshop($_POST['name'],$_POST['content'],	$_POST['media_path'], $_POST['media_type'],$_POST['difficulty'],$_POST['robot'],$_POST['grade']);
				$this->workshopAdded = true;
				$this->workshopMod  = WorkshopDAO::getWorkshopByNameAndContent($_POST['name'],$_POST['content']);
			} catch (\Throwable $th) {
				$this->workshopAdded = false;
			}

		}

		private function assignWorkshopToMember()
		{
			$id_member = $_POST['members_list'][0];
			$this->assignFamily = true;
			$this->familyWorkshops = WorkshopDAO::selectMemberWorkshop($id_member);
		}


	}
