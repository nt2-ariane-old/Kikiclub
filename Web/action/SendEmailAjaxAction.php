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

			$headers = "Reply-To: Kikiclub <do-not-reply@doutreguay.com>\r\n";
			$headers .= "Return-Path: Kikiclub <do-not-reply@doutreguay.com>\r\n";
			$headers .= "From: Kikiclub <do-not-reply@doutreguay.com>\r\n";

			$headers .= "Organization: Code & Café\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "X-Priority: 3\r\n";
			$headers .= "X-Mailer: PHP". phpversion() ."\r\n";

			$subject = "";

			$htmlContent = "";

			var_dump($_POST);

			if(!empty($_POST["workshop"]))
			{
				$subject = "Nouvel Atelier!! :D ";
				$htmlContent = file_get_contents("template.php");
				$workshop =$_POST["workshop"];
				$htmlContent = str_replace("***WORKSHOP***",$workshop["NAME"],$htmlContent);
				$htmlContent = str_replace("***CONTENT***",$workshop["CONTENT"],$htmlContent);
				$htmlContent = str_replace("***PATH***",$workshop["MEDIA_PATH"],$htmlContent);
			}

			echo $htmlContent;

			try {
				foreach ($users as $user) {
					$to = $user["EMAIL"];
					$htmlContent = str_replace("***USER***",$user["FIRSTNAME"],$htmlContent);
					mail($to,$subject,$htmlContent,$headers);

				}
				$this->results = true;
			} catch (\Throwable $th) {
				echo $th;
				$this->results = false;
			}
		}
	}