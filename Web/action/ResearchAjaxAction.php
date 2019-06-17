<?php
	require_once("action/CommonAction.php");

	require_once("action/DAO/WorkshopDAO.php");
	require_once("action/DAO/FamilyDAO.php");
	require_once("action/DAO/UsersDAO.php");

	class ResearchAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,"research-ajax");
		}

		protected function executeAction() {
			if(isset($_POST["name"]))
			{
				$name = $_POST["name"];
				if(isset($_POST["workshop"]))
				{
					$this->results = WorkshopDAO::getWorkshopsLikeName($name);
				}
				if(isset($_POST["user"]))
				{
					$this->results = UsersDAO::getUsersLikeName($name);
				}
				if(isset($_POST["family"]))
				{
					$this->results = FamilyDAO::getFamilyLikeName($name);

				}
			}

		}
	}