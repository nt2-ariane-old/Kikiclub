<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/FamilyDAO.php");
	require_once("action/DAO/UsersDAO.php");
	require_once("action/DAO/RobotDAO.php");
	class ConsoleAction extends CommonAction {
		//liste d'objets et objet individuel a modifier
		public $workshops;
		public $workshopMod;

		public $users;
		public $userMod;

		public $family;
		public $familyMod;
		public $familyWorkshops;

		public $avatars;

		public $difficulties;
		public $robots;
		//differentes fonctions d'administrations (true si utiliser, false si non)
		public $modify;
		public $add;
		public $addFamily;
		public $modFamily;
		public $assignFamily;


		//Page en cours
		public $pageWorkshops;
		public $pageUsers;

		//Error infos
		public $error;
		public $errorMsg;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"console", "Admin Console");
			$this->add = false;
			$this->modify=false;

			$this->addFamily=false;
			$this->modFamily=false;
			$this->assignFamily=false;

			$this->pageWorkshops=false;
			$this->pageUsers=false;

			$this->error = false;
		}

		protected function executeAction()
		{
			$this->preparePage();
			$this->checkAction();
		}

		//Prepare the page before doing action
		private function preparePage()
		{
			$this->workshops = WorkshopDAO::getWorkshops();
			$this->users = FamilyDAO::getUsers();
			$this->difficulties = WorkshopDAO::getDifficulties();
			$this->robots = RobotDAO::getRobots();

			if(isset($_POST["users"]))
			{
				$_SESSION["users"] = true;
				unset($_SESSION['workshops']);
			}
			else if (isset($_POST["workshops"]))
			{
				$_SESSION["workshops"] = true;
				unset($_SESSION['users']);
			}

			if(isset($_SESSION["users"]))
			{
				$this->pageUsers=true;
			}
			else if (isset($_SESSION["workshops"]))
			{
				$this->pageWorkshops=true;
			}

			if(!empty($_POST['members_list']))
			{
				$_SESSION["member"] = $_POST['members_list'][0];
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
					if($this->pageWorkshops)
					{
						$this->addWorkshop();
					}
					else if($this->pageUsers)
					{
						$this->addUser();
					}
				}
			}
			else if(isset($_POST['modify']) && !isset($_POST['back']))
			{
				$this->modify = true;
				if(!empty($_POST['members_list']))
				{
					$this->modifyMember();
				}
				else if($this->pageWorkshops)
				{
					$this->modifyWorkshop();
				}
				else if($this->pageUsers)
				{
					$this->modifyUser();
				}
			}
			else if($this->pageUsers && isset($_POST['assign']) && !isset($_POST['back']) && !empty($_POST['members_list']))
			{
				$this->assignWorkshopToMember();
			}
			else if($this->pageUsers && isset($_POST['addFamily']) && !isset($_POST['back']) && !empty($_POST['users_list']))
			{
				$this->addMember();
			}
			else if(isset($_POST['delete']))
			{
				if($this->pageWorkshops)
				{
					$this->deleteWorkshops();
				}
				else if($this->pageUsers)
				{
					$this->deleteUsersAndMembers();
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
				foreach($_POST['users_list'] as $users)
				{
					FamilyDAO::deleteUsers($users);
				}
			}
			header("Location:console.php");
		}
		private function modifyUser()
		{
			if(!empty($_POST['users_list']))
			{
				$this->userMod = UsersDAO::selectUser(intval($_POST['users_list'][0]));

				if(isset($_POST['push']))
				{
					UsersDAO::updateUser(intval($_POST['users_list'][0]),$_POST['email'],$_POST['firstname'],$_POST['lastname']);
					header('location:console.php');
				}
			}
		}

		private function modifyMember()
		{

			$this->modify = false;
			$this->modFamily = true;
			$this->familyMod = FamilyDAO::selectMember($_POST['members_list'][0]);
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

		private function modifyWorkshop()
		{
			if(!empty($_POST['workshops_list']))
			{
				$this->workshopMod = WorkshopDAO::selectWorkshop(intval($_POST['workshops_list'][0]));
				if(isset($_POST['push']))
				{
					$target_path = "uploads/";
					$target_path = $target_path . basename( $_FILES['workshopFile']['name']);
					$type =  pathinfo($target_path, PATHINFO_EXTENSION);

					if($_FILES['workshopFile']['error'] == 2)
					{
						$this->error = true;
						$this->errorMsg = "Uploaded file is too big...";
					}
					move_uploaded_file($_FILES['workshopFile']['tmp_name'], $target_path);

					WorkshopDAO::updateWorkshop(intval($_POST['workshops_list'][0]),$_POST['name'],$_POST['content'],$target_path,$type,$_POST['difficulty'],$_POST['robot']);
					header('location:console.php');

				}

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
			UsersDAO::registerUser($_POST['email'],null,$_POST['firstname'],$_POST['lastname'],CommonAction::$VISIBILITY_CUSTOMER_USER);
		}

		private function addWorkshop()
		{
			$target_path = "uploads/";
			var_dump($_FILES);
			$target_path = $target_path . basename( $_FILES['workshopFile']['name']);
			if($_FILES['workshopFile']['error'] == 2)
			{
				$this->error = true;
				$this->errorMsg = "Uploaded file is too big...";
			}
			$type =  pathinfo($target_path, PATHINFO_EXTENSION);
			move_uploaded_file($_FILES['workshopFile']['tmp_name'], $target_path);

			WorkshopDAO::addWorkshop($_POST['name'],$_POST['content'],	$target_path, $type,$_POST['difficulty'],$_POST['robot']);
		}

		private function assignWorkshopToMember()
		{
			$this->assignFamily = true;
			$this->familyWorkshops = WorkshopDAO::selectMemberWorkshop($_POST['members_list'][0]);
		}


	}
