<?php
	session_start();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/constante.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/Tools/Translator.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/MemberDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/Mobile_Detect.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersDAO.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/UsersConnexionDAO.php");
	abstract class CommonAction
	{
		public static $VISIBILITY_PUBLIC = 0;
		public static $VISIBILITY_CUSTOMER_USER = 1;
		public static $VISIBILITY_ANIMATOR = 2;
		public static $VISIBILITY_MODERATOR = 3;
		public static $VISIBILITY_ADMIN_USER = 4;
		public static $VISIBILITY_OWNER = 5;

		public $default_visibility;
		public $page_visibility;
		public $page_name;
		public $complete_name;

		public $member_name;
		public $member_avatar;

		public $members;
		public $avatars;
		public $trans;
		public $url;

		public $detect;

		public $admin_mode;

		public $previous_page;

		public function __construct($page_visibility,$page_name)
		{
			$this->page_visibility = $page_visibility;
			$this->page_name = $page_name;
			$this->default_visibility = 1;
			$this->url = $_SERVER['HTTP_HOST'];
			$this->detect = new Mobile_Detect;
			$this->admin_mode = false;
		}

		public function generateFormToken($form) {
			 $token = md5(uniqid(microtime(), true));
			 $_SESSION[$form.'_token'] = $token;

			 return $token;
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
		public function isMember()
		{
			return !empty($_SESSION["member_id"]);
		}
		public function isAdmin() {
			return $_SESSION["visibility"] > CommonAction::$VISIBILITY_CUSTOMER_USER;
		}

		public function execute()
		{
			//check if user want to logout
			error_reporting(E_ALL);

			if(!empty($_GET["logout"]))
			{
				session_unset();
				session_destroy();
				session_start();
				header("location:index.php");
				exit;
			}


			//check what is the current visibility and
			// if the page visibility is greater than the user visibility redirect to home page
			if(empty($_SESSION["visibility"]))
			{
				$_SESSION["visibility"] = CommonAction::$VISIBILITY_PUBLIC;
			}

			if($_SESSION["visibility"] < $this->page_visibility)
			{
				header("location:index.php");
				exit;
			}

			if(!empty($_GET["token"]))
			{
				$_SESSION["referral"] = $_GET["token"];
				header('Location:reference.php');
			}
			//check if they're is a connection token and test it
			if(!empty($_GET["user_t"]))
			{
				$id = UsersDAO::getUserFromToken($_GET["user_t"]);

				//if token is working
				if(!empty($id))
				{
					
					//get user info
					$user = UsersDAO::getUserWithID($id);
				 	$_SESSION["visibility"] = $user["visibility"];
					$_SESSION["id"] = $user["id"];

					//delete token
					 UsersDAO::deleteToken($_GET["user_t"]);
					 UsersConnexionDAO::insertUserConnexion($_SESSION["id"]);
					 $connexion = UsersConnexionDAO::getUserConnexion($_SESSION["id"]);
					if(sizeof($connexion) <= 1)
					{
						header('Location:reference.php');
					}
				}
			}

if(!empty($_SESSION["referral"]) && $this->page_name != "reference")
{
	header('location:reference.php');
}

			//check current page

			if(strpos($this->page_name, 'error') === false && strpos($this->page_name, 'ajax') === false && $this->page_name != "assign-member")
			{
				if(!empty( $_SESSION["current"]))
				{
					if($_SESSION["current"] != $this->page_name)
					{

						$_SESSION["previous"] = $_SESSION["current"];
					}
				}
				else
				{
					$_SESSION["previous"] = "index";
				}
				$_SESSION["current"] = $this->page_name;
				$this->previous_page = $_SESSION["previous"];

			}
			else
			{
				$this->previous_page = $_SESSION["previous"];
			}

			//Check if admin want to be in admin mode
			if($this->isAdmin())
			{
				if(!isset($_SESSION["admin_mode"]))
				{
					$_SESSION["admin_mode"] = false;
				}

				if(!empty($_GET["admin"]))
				{
					if($_GET["admin"] === "true")
					{

						$_SESSION["admin_mode"] = true;
					}
					else
					{
						$_SESSION["admin_mode"] = false;
					}

				}
				$this->admin_mode = $_SESSION['admin_mode'];

			}
			//check language and translate
			if(empty($_SESSION["language"]))
			{
				$_SESSION["language"] = "fr";
			}

			if (isset($_GET["lang"]) && strlen($_GET["lang"]) > 0) {
				$_SESSION["language"] = $_GET["lang"];
			}

			$currentLang = $_SESSION["language"];

			$this->trans = new Translator($currentLang);

			//translate page name
			if(strpos($this->page_name, 'error') === false && strpos($this->page_name, 'ajax') === false)
			{
				$this->complete_name = $this->trans->read("pages_name",$this->page_name);
			}

			if($this->isLoggedIn())
			{
				$this->members = MemberDAO::selectFamily($_SESSION["id"]);
			}

			$this->avatars = MemberDAO::loadAvatar();;
			//check if the family member exist, and if yes, show is name
			if($this->isMember())
			{
				$member = MemberDAO::selectMember($_SESSION["member_id"]);
				if($member == null)
				{
					unset($_SESSION["member_id"]);
				}
				else
				{
					$this->member_name = $member["firstname"];
					$this->member_avatar = $this->avatars[$member["id_avatar"]] ;
				}
			}

			
			
			//execute page action
			$this->executeAction();
		}

		protected abstract function executeAction();

	}