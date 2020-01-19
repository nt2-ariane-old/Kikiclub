<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/WorkshopDAO.php");

	class MaterialsAction extends CommonAction {
        public $materials;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'materials');
			
		}

		protected function executeAction() {
            $this->materials = WorkshopDAO::getMaterials();
        }

	}