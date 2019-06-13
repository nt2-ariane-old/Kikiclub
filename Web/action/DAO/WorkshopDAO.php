<?php
	require_once("action/DAO/Connection.php");

	class WorkshopDAO {

		public static function getWorkshops() { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,ID_ROBOT,NAME,CONTENT,MEDIA_PATH, MEDIA_TYPE,ID_DIFFICULTY FROM WORKSHOPS ");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function getWorkshopsScoreValue($id_robot, $id_difficulty)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT score FROM WORKSHOP_SCORE WHERE ID_WORKSHOP = ? AND ID_DIFFICULTY=?");
			$statement->bindParam(1, $id_workshop);
			$statement->bindParam(2, $id_difficulty);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$value = [];

			if ($row = $statement->fetch()) {
				$value = $row["score"];
			}

			return $value;
		}
		public static function getDifficulties()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM DIFFICULTY");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function addWorkshop($name, $content, $MEDIA_PATH, $MEDIA_TYPE,$difficulty){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO WORKSHOPS(NAME,CONTENT,MEDIA_PATH, MEDIA_TYPE,ID_ROBOT,ID_DIFFICULTY) VALUES (?,?,?,?,?)");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $MEDIA_PATH);
			$statement->bindParam(4, $MEDIA_TYPE);
			$statement->bindParam(5, $difficulty);
			$statement->execute();
		}
		public static function updateWorkshop($id,$name, $content, $MEDIA_PATH, $MEDIA_TYPE, $difficulty){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("UPDATE WORKSHOPS SET NAME=?,CONTENT=?,MEDIA_PATH=? , MEDIA_TYPE=?, ID_DIFFICULTY=? WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $MEDIA_PATH);
			$statement->bindParam(4, $MEDIA_TYPE);
			$statement->bindParam(5, $difficulty);
			$statement->bindParam(6, $id);
			$statement->execute();
		}
		public static function deleteWorkshop($id){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM WORKSHOPS WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();
		}
		public static function selectMemberWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID_MEMBER, ID_WORKSHOP, STATUT, LAST_MODIFICATION FROM FAMILY_WORKSHOPS WHERE ID_MEMBER=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["ID_WORKSHOP"]] = $row;
			}

			return $content;
		}
		public static function selectMemberNewWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID, NAME, CONTENT, MEDIA_PATH , MEDIA_TYPE ,ID_ROBOT, ID_DIFFICULTY FROM WORKSHOPS WHERE ID NOT IN (SELECT ID_WORKSHOP FROM FAMILY_WORKSHOPS WHERE ID_MEMBER=?)");

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function addMemberWorkshop($id_member,$id_workshop, $statut)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO FAMILY_WORKSHOPS(ID_MEMBER, ID_WORKSHOP, STATUT) VALUES (?,?,?)");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->bindParam(2, $id_workshop);
			$statement->bindParam(3, $statut);
			$statement->execute();
		}
		public static function updateMemberWorkshop($id_member,$id_workshop, $statut)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE FAMILY_WORKSHOPS SET STATUT = ?, LAST_MODIFICATION=CURRENT_TIMESTAMP WHERE ID_MEMBER = ? AND ID_WORKSHOP=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $statut);
			$statement->bindParam(2, $id_member);
			$statement->bindParam(3, $id_workshop);
			$statement->execute();
		}
		public static function selectWorkshop($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID, NAME, CONTENT, MEDIA_PATH , MEDIA_TYPE ,ID_ROBOT, ID_DIFFICULTY FROM WORKSHOPS WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
			}

			return $content;
		}

		public static function selectWorkshopQuestions($id_workshop)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID, QUESTION, ANSWER FROM WORKSHOPS_QUESTION WHERE id_workshop=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_workshop);
			$statement->execute();

			$content = [];

			while ($row[] = $statement->fetch()) {
				$content = $row;
			}

			return $content;
		}
	}
