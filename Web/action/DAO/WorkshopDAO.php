<?php
	require_once("action/DAO/Connection.php");

	class WorkshopDAO {

		public static function getWorkshops() { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,NAME,CONTENT,IMAGE_PATH FROM WORKSHOPS ");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
	}
