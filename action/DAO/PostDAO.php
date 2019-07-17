<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/Connection.php");

	class PostDAO {

		public static function getPosts($min=0,$nb=null)
		{
			$connection = Connection::getConnection();
			if($nb == null){
				$statement = $connection->prepare("SELECT shared_posts.ID AS ID, shared_posts.TITLE AS TITLE,shared_posts.CONTENT AS CONTENT,shared_posts.MEDIA_PATH AS MEDIA_PATH,shared_posts.MEDIA_TYPE AS MEDIA_TYPE , shared_posts.ID_USER AS ID_USER, CONCAT(users.FIRSTNAME, ' ',users.LASTNAME) AS USERNAME FROM shared_posts INNER JOIN users ON shared_posts.ID_USER=users.ID");
			}
			else
			{
				$statement = $connection->prepare("SELECT shared_posts.ID AS ID, shared_posts.TITLE AS TITLE,shared_posts.CONTENT AS CONTENT,shared_posts.MEDIA_PATH AS MEDIA_PATH,shared_posts.MEDIA_TYPE AS MEDIA_TYPE , shared_posts.ID_USER AS ID_USER, CONCAT(users.FIRSTNAME, ' ',users.LASTNAME) AS USERNAME FROM shared_posts INNER JOIN users ON shared_posts.ID_USER=users.ID LIMIT ?,?");
				$statement->bindParam(1, $min);
				$statement->bindParam(2, $nb);
			}
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function deletePost($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM shared_posts WHERE ID=?");
			$statement->bindParam(1, $id);
			$statement->execute();
		}
		public static function insertPost($id_user,$title,$content,$media_path, $media_type)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO shared_posts(TITLE,CONTENT,MEDIA_PATH,MEDIA_TYPE,ID_USER) VALUES (?,?,?,?,?)");
			$statement->bindParam(1, $title);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $media_path);
			$statement->bindParam(4, $media_type);
			$statement->bindParam(5, $id_user);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
		public static function updatePost($id,$title,$content,$media_path, $media_type)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE shared_posts SET TITLE=?,CONTENT=?,MEDIA_PATH=?,MEDIA_TYPE=? WHERE ID=?");
			$statement->bindParam(1, $title);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $media_path);
			$statement->bindParam(4, $media_type);
			$statement->bindParam(5, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

}