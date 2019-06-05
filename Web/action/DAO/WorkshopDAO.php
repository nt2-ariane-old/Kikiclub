<?php
	require_once("action/DAO/Connection.php");

	class UsersDAO {

		//PAGE

		public static function getParent($wix_id) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,NAME,SCORE FROM PARENTS WHERE WIX_ID=?");
			$statement->bindParam(1, $wix_id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function getFamily($id) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,NAME,SCORE FROM FAMILY WHERE ID_PARENT=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
	}
