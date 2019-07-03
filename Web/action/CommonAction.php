<?php
	session_start();
	require_once("action/constante.php");
	require_once("action/Tools/Translator.php");
	require_once("action/DAO/FamilyDAO.php");

	abstract class CommonAction
	{
		public static $VISIBILITY_PUBLIC = 0;
		public static $VISIBILITY_FAMILY_MEMBER = 1;
		public static $VISIBILITY_CUSTOMER_USER = 2;
		public static $VISIBILITY_ADMIN_USER = 3;

		public $default_visibility;
		public $page_visibility;
		public $page_name;
		public $complete_name;

		public $member_name;

		public $trans;



		public function __construct($page_visibility,$page_name,$complete_name)
		{
			$this->page_visibility = $page_visibility;
			$this->page_name = $page_name;
			$this->complete_name = $complete_name;
			$this->default_visibility = 1;
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


		public function isLoggedIn() {
			return $_SESSION["visibility"] > CommonAction::$VISIBILITY_PUBLIC;
		}
		public function isFamilyMember()
		{
			return !empty($_SESSION["member"]);
		}
		public function isAdmin() {
			return $_SESSION["visibility"] > CommonAction::$VISIBILITY_CUSTOMER_USER;
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

			if(empty($_SESSION["language"]))
			{
				$_SESSION["language"] = "fr";
			}

			if (isset($_GET["lang"]) && strlen($_GET["lang"]) > 0) {
				$_SESSION["language"] = $_GET["lang"];
			}

			$currentLang = $_SESSION["language"];

			$this->trans = new Translator($currentLang);


			if(!empty($_POST["member"]))
			{
				$_SESSION["member"] = $_POST["member"];
			}

			if($this->isFamilyMember())
			{
				$member = FamilyDAO::selectMember($_SESSION["member"]);
			 	$this->member_name = $member["firstname"];
			}
			$this->executeAction();
		}

		protected abstract function executeAction();

	}