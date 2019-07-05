<?php
	require_once("action/DAO/Connection.php");

	class BadgeDAO {

		public static function getBadges($id_type=null)
		{
			$request = "SELECT  * FROM BADGES";

			if(!empty($id_type))
			{
				$request .= " WHERE ID_BADGE_TYPE=?";
			}
			$connection = Connection::getConnection();

			$statement = $connection->prepare($request);

			if(!empty($id_type))
			{
				$statement->bindParam(1, $id_type);
			}

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function getFamilyBadges($id_user, $id_member=null)
		{
			$connection = Connection::getConnection();

			$request = "SELECT ";
			$request .= "b.NAME AS NAME, b.MEDIA_PATH AS MEDIA_PATH, b.MEDIA_TYPE AS MEDIA_TYPE, f.FIRSTNAME AS OWNER, DATE_FORMAT(fb.won_on, '%Y-%m-%d') AS WON_ON ";
			$request .= "FROM FAMILY_BADGES AS fb INNER JOIN BADGES AS b INNER JOIN FAMILY AS f ";
			$request .= "WHERE fb.ID_BADGE = b.ID AND fb.ID_USER = ? AND f.id = fb.id_member ";

			if(!empty($id_member))
			{
				$request .= "AND fb.id_member = ?";
			}
			$statement = $connection->prepare( $request);
			$statement->bindParam(1, $id_user);
			if(!empty($id_member))
			{
				$statement->bindParam(2, $id_member);
			}

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function getMemberBadge($id_member)
		{
			$connection = Connection::getConnection();

			$request = "SELECT ";
			$request .= "b.ID AS ID_BADGE, b.NAME AS NAME, b.MEDIA_PATH AS MEDIA_PATH, b.MEDIA_TYPE AS MEDIA_TYPE, f.FIRSTNAME AS OWNER, DATE_FORMAT(fb.won_on, '%Y-%m-%d') AS WON_ON ";
			$request .= "FROM FAMILY_BADGES AS fb INNER JOIN BADGES AS b INNER JOIN FAMILY AS f ";
			$request .= "WHERE fb.ID_BADGE = b.ID AND fb.id_member = ? AND f.id = fb.id_member ";


			$statement = $connection->prepare( $request);
			$statement->bindParam(1, $id_member);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["ID_BADGE"]] = $row;
			}

			return $content;
		}

		public static function addBadgeToMember($id_badge,$id_member,$id_user)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO FAMILY_BADGES(ID_BADGE,ID_MEMBER,ID_USER,WON_ON) VALUES (?,?,?,CURDATE())");

			$statement->bindParam(1, $id_badge);
			$statement->bindParam(2, $id_member);
			$statement->bindParam(3, $id_user);

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