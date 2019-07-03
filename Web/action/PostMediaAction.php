<?php
	require_once("action/CommonAction.php");

	class PostMediaAction extends CommonAction {

		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, 'post-media', 'Post Media');
		}

		protected function executeAction() {
			$this->post_upload();
		}
		public function post_upload(){

			$uploaddir = 'uploads-users/';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				$this->results["PATH"] =  $uploadfile;
				$this->results["TYPE"] =  pathinfo($uploadfile, PATHINFO_EXTENSION);
			} else {
				$this->results =  "Possible file upload attack!\n";
			}

		}
	}