<?php
	require_once("action/DAO/Connection.php");

	class WorkshopDAO {

		public static function getWorkshops() { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,NAME,CONTENT,IMAGE_PATH, DIFFICULTY FROM WORKSHOPS ");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function addWorkshop($name, $content, $image_path, $difficulty){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO WORKSHOPS(NAME,CONTENT,IMAGE_PATH, DIFFICULTY) VALUES (?,?,?,?)");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $image_path);
			$statement->bindParam(4, $difficulty);
			$statement->execute();
		}
		public static function updateWorkshop($id,$name, $content, $image_path, $difficulty){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("UPDATE WORKSHOPS SET NAME=?,CONTENT=?,IMAGE_PATH=?, DIFFICULTY=? WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $image_path);
			$statement->bindParam(4, $difficulty);
			$statement->bindParam(5, $id);
			$statement->execute();
		}
		public static function deleteWorkshop($id){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM WORKSHOPS WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();
		}
		public static function selectWorkshop($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID, NAME, CONTENT, IMAGE_PATH, DIFFICULTY FROM WORKSHOPS WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
			}

			return $content;
		}
	}
