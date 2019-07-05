<?php
	require_once("action/DAO/Connection.php");

	class BadgeDAO {

		public static function getBadges($min=0,$nb=null)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT  * FROM BADGES");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function getFamilyBadges($id_user)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT  * FROM BADGES INNER JOIN FAMILY_BADGES WHERE FAMILY_BADGES.ID_BADGE = BADGES.ID AND FAMILY_BADGES.ID_USER = ? ");
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