<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/FamilyDAO.php");
	class ConsoleAction extends CommonAction {
		public $workshops;
		public $workshopMod;

		public $users;

		public $modify;
		public $add;


		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"Console");
			$this->add = false;
			$this->modify=false;
		}

		protected function executeAction() {
			var_dump($_POST);
			$this->workshops = WorkshopDAO::getWorkshops();
			$this->users = FamilyDAO::getUsers();
			if(isset($_POST['add']) && !isset($_POST['back']))
			{
				$this->add = true;
				if(isset($_POST['push']))
				{
					WorkshopDAO::addWorkshop($_POST['name'],$_POST['content'],'./images/logoNom.png',$_POST['difficulty']);
				}
			}
			else if(isset($_POST['delete']))
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
			else if(isset($_POST['modify']) && !isset($_POST['back']))
			{
				$this->modify = true;

				if(!empty($_POST['workshops_list']))
				{
					$this->workshopMod = WorkshopDAO::selectWorkshop(intval($_POST['workshops_list'][0]));
					if(isset($_POST['push']))
					{
						WorkshopDAO::updateWorkshop(intval($_POST['workshops_list'][0]),$_POST['name'],$_POST['content'],'./images/logoNom.png',$_POST['difficulty']);
						header('location:console.php');
					}
				}

			}
		}
	}