<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class BasicAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'basic-ajax','Basics Ajax');
		}

		protected function executeAction() {

			if(isset($_POST["set_value"]))
			{
				unset($_POST["set_value"]);

				foreach ($_POST as $key => $value) {
					$_SESSION[$key] = $value;
				}
			}

		}
	}