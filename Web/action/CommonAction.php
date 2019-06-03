<?php
	session_start();

	abstract class CommonAction
	{
		public static $VISIBILITY_PUBLIC = 0;
		public static $VISIBILITY_MEMBERS = 1;
		public static $VISIBILITY_MODERATORS = 2;
		public static $VISIBILITY_ADMINISTRATORS = 3;
		public static $VISIBILITY_OWNER = 4;

		public $page_visibility;
		public $page_name;

		public function __construct($page_visibility,$page_name)
		{
			$this->page_visibility = $page_visibility;
			$this->page_name = $page_name;
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