<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/BadgeDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersConnexionDAO.php");

	class ReferenceAction extends CommonAction {
		public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'plan-du-site');
    
		}

		protected function executeAction() {
        
		}
       
        
    }
