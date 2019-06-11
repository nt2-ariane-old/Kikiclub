<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/WorkshopDAO.php");

	class ConsoleAction extends CommonAction {
		public $workshops;
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
			if(!empty($_POST['add']))
			{
				echo("hello");
				$this->add = true;
			}
			else if(!empty($_POST['delete']))
			{

			}
			else if(!empty($_POST['modify']))
			{
				$this->modify = true;
			}
		}
	}