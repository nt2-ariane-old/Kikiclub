<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UsersDAO.php");

	class SendEmailAjaxAction extends CommonAction {

		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'send-email-ajax','Send Email');
		}

		protected function executeAction() {
			$users = UsersDAO::getAllUsers();

			$subject = "Petit Test";
			$msg = "Ceci est un petit test pour voir si j'envois des emails";

			$othermsg = require_once("emails/test.php");

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


			$headers .= "From: do-not-reply@kikiclub.ca";

			try {
				foreach ($users as $user) {
					$to = $user["EMAIL"];
					mail($to,$subject,$msg,$headers);

				}
				$this->results = true;
			} catch (\Throwable $th) {
				echo $th;
				$this->results = false;
			}

		}
	}