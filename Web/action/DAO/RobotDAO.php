<?php
	require_once("action/DAO/Connection.php");

	class RobotDAO {

		public static function getRobots()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM ROBOT");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["ID"]] = $row;
			}

			return $content;
		}

}