<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/PostDAO.php");

	class PostsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'posts-ajax','Posts Ajax');
		}

		protected function executeAction() {
			if(isset($_POST["delete"]) && !empty($_POST["id"]))
			{
				PostDAO::deletePost(intval($_POST["id"]));
			}

			if(isset($_POST["insert"]) && !empty($_POST["title"]))
			{
				$content = "";
				$path = "";
				$type = "";
				var_dump($_POST);

				if(!empty($_POST["content"]))
					$content=$_POST["content"];
				if(!empty($_POST["media_path"]))
					$path=$_POST["media_path"];
				if(!empty($_POST["media_type"]))
					$type=$_POST["media_type"];

				PostDAO::insertPost($_SESSION["id"],$_POST["title"],$content,$path,$type);
			}

			$nbPostByPage = 4;
			if(!empty($_POST["page"]))
			{
				$page = intval($_POST["page"]) * $nbPostByPage;
			}
			else
			{
				$page = 0;
			}
			$this->results["posts"] = PostDAO::getPosts($page,$nbPostByPage);

			$this->results["nbPages"] = ceil(sizeof(PostDAO::getPosts()) / $nbPostByPage);

		}
	}