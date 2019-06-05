<?php
	session_start();
	require_once("action/constante.php");
	abstract class CommonAction
	{
		public static $VISIBILITY_PUBLIC = 0;
		public static $VISIBILITY_FAMILY_MEMBER = 1;
		public static $VISIBILITY_CUSTOMER_USER = 2;
		public static $VISIBILITY_ADMIN_USER = 4;

		public $page_visibility;
		public $page_name;

		public function __construct($page_visibility,$page_name)
		{
			$this->page_visibility = $page_visibility;
			$this->page_name = $page_name;
		}

		public function generateFormToken($form) {
			 $token = md5(uniqid(microtime(), true));
			 $_SESSION[$form.'_token'] = $token;

			 return $token;
		}

		public function checkPost()
		{
			$whitelist = array('token','req-name','req-email','typeOfChange','urgency','URL-main','addURLS', 'curText', 'newText', 'save-stuff');
			foreach ($_POST as $key=>$item) {
				if (!in_array($key, $whitelist)) {
					die("Hack-Attempt detected. Please use only the fields in the form");
				}
			}
		}

		public function verifyFormToken($form) {
			$valide = true;

			if(!isset($_SESSION[$form.'_token'])) {
				$valide = false;
			}

			if(!isset($_POST['token'])) {
				$valide = false;
			}

			if ($_SESSION[$form.'_token'] !== $_POST['token']) {
				$valide = false;
			}

			return $valide;
		}

		public function execute()
		{
			if(!empty($_GET["logout"]))
			{
				session_unset();
				session_destroy();
				session_start();
				header("location:index.php");
				exit;
			}
			if(empty($_SESSION["visibility"]))
			{
				$_SESSION["visibility"] = CommonAction::$VISIBILITY_PUBLIC;
			}
			if($_SESSION["visibility"] < $this->page_visibility)
			{
				header("location:index.php");
				exit;
			}
			$this->executeAction();
		}

		protected abstract function executeAction();

		public function isLoggedIn() {
			return $_SESSION["visibility"] > CommonAction::$VISIBILITY_PUBLIC;
		}
	}