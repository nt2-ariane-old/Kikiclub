<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/PostDAO.php");

	class SharedAction extends CommonAction {

		public $nbPages;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'shared','Shared Posts');
		}

		protected function executeAction() {
			$this->complete_name = $this->trans->read("main","share");
		}

	}