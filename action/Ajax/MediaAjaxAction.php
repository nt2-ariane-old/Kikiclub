<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/CommonAction.php");

	class MediaAjaxAction extends CommonAction {

		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, 'media-ajax', 'Media Ajax');
		}

		protected function executeAction() {
			$this->post_upload();
		}
		public function post_upload(){

			$dir = $_POST["dir"];
			$max_size = 1024 * 1024 * 10;

			$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/" . $dir . "/";
			$webdir = "https://" . $_SERVER['HTTP_HOST'] . "/" . $dir . "/";

			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
			$webfile = $webdir . basename($_FILES['file']['name']);

			$accepeted_type = ['video/mp4','image/png','image/jpeg','image/gif','audio/mp3'];
			if(in_array($_FILES['file']['type'],$accepeted_type))
			{
				if($_FILES["file"]["size"] <= $max_size)
				{
					if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
						$this->results["PATH"] =  $webfile;
						$this->results["TYPE"] =  pathinfo($webfile, PATHINFO_EXTENSION);
					} else {
						$this->results =  "Possible file upload attack!";
					}
				}
				else
				{
					$this->results =  "Max size exceeded";
				}
			}
			else
			{
				$this->results =  "Type not accepted";
			}





		}
	}