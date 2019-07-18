<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class BasicAjaxAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'basic-ajax','Basics Ajax');
		}

		protected function executeAction() {
			if(!empty($_POST["member"]))
			{
				$_SESSION["member"] = $_POST["member"];
			}
		}
	}