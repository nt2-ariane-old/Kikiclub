<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");

	class ConsoleAction extends CommonAction {
		public $workshops;
		public $workshopMod;
		public $modify;
		public $add;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"Console");
			$this->add = false;
			$this->modify=false;
		}

		protected function executeAction() {
			$this->workshops = WorkshopDAO::getWorkshops();
			var_dump($_POST);
			if(isset($_POST['add']) && !isset($_POST['back']))
			{
				$this->add = true;
				if(isset($_POST['push']))
				{
					WorkshopDAO::addWorkshop($_POST['name'],$_POST['content'],'./images/logoNom.png',$_POST['difficulty']);
				}
			}
			else if(!empty($_POST['delete']))
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
			else if(!empty($_POST['modify']))
			{
				$this->modify = true;

				if(!empty($_POST['workshops_list']))
				{
					$this->workshopMod = WorkshopDAO::selectWorkshop(intval($_POST['workshops_list'][0]));
					if(isset($_POST['push']))
					{
						WorkshopDAO::updateWorkshop($_POST['workshop_id'],$_POST['name'],$_POST['content'],'./images/logoNom.png',$_POST['difficulty']);
					}
				}

			}
		}
	}