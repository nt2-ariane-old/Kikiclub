<?php
	require_once("action/CommonAction.php");

	class LoginAjaxAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "loginAjax");

		}

		protected function executeAction() {
			var_dump($_POST);
			$_SESSION["executed"] = true;
		}
	}