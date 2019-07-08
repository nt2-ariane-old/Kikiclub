<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/PostDAO.php");

	class SharedAction extends CommonAction {

		public $nbPages;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'shared','Shared Posts');
		}

		protected function executeAction() {
			$this->complete_name = $this->trans->read("main","share");
		}

	}