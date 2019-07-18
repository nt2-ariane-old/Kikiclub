<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/BadgeDAO.php");

	class BadgesAjaxAction extends CommonAction {

		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_MODERATOR,'badges-ajax','badges ajax');
		}

		protected function executeAction() {
			$this->results = [];
			if(isset($_POST["add"]))
			{
				$this->results["types"] = BadgeDAO::getBadgesType();
				BadgeDAO::addBadge();
				$this->results["id"] = BadgeDAO::getIdFromLastCreated();

			}
			if(isset($_POST["modify"]))
			{
				$id = $_POST["id"];
				$badge = BadgeDAO::getBadgeByID($id);

				$params = $_POST["params"];

				foreach ($params as $key => $value) {
					$badge[$key] = $value;
				}

				BadgeDAO::updateBadge($id,$badge["NAME"],$badge["ID_BADGE_TYPE"], $badge["VALUE_NEEDED"],$badge["MEDIA_PATH"],$badge["MEDIA_TYPE"]);
				$this->results = true;
			}
			if(isset($_POST["delete"]))
			{

				BadgeDAO::deleteBadge($_POST["id"]);
			}
		}
	}