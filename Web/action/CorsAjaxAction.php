<?php
	require_once("action/CommonAction.php");

	class CorsAjaxAction extends CommonAction {
		public $result;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"Cors-Ajax");

		}

		protected function executeAction() {
			if(!empty($_POST[""]))
			{
				$_SESSION["isLoggedIn"] = $_POST[""];
			}
			$this->result = true;
		}
	}