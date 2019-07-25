<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/Connection.php");

	/**
	 * Access to all filter related informations in the database
	 *
	 * @link       https://doutreguay.com/action/DAO/FilterDAO
	 * @since      Class available since Alpha 1.0.0
	 */
	class FilterDAO {
		/**
		 * Insert a new workshop's filter
		 *
		 * @param integer   $id_workshop id of the workshop
		 * @param integer   $id_type type of the filter
		 * @param integer   $id_filter id of the filter (ex : if id_type is difficulty, id of a difficulty)
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function insertWorkshopFilters($id_workshop,$id_type,$id_filter)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO workshop_filters(id_workshop,id_type,id_filter) VALUES(?,?,?)");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_workshop);
			$statement->bindParam(2, $id_type);
			$statement->bindParam(3, $id_filter);

			$statement->execute();
		}

		/**
		 * Update a workshop's filter
		 *
		 * @param integer   $id id of the filter
		 * @param integer   $id_workshop id of the workshop
		 * @param integer   $id_type type of the filter
		 * @param integer   $id_filter id of the filter (ex : if id_type is difficulty, id of a difficulty)
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function updateWorkshopFilters($id,$id_workshop,$id_type,$id_filter)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("UPDATE workshop_filters SET id_workshop=?,id_type=?,id_filter=? WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_workshop);
			$statement->bindParam(2, $id_type);
			$statement->bindParam(3, $id_filter);
			$statement->bindParam(4, $id);

			$statement->execute();
		}

		/**
		 * Delete a workshop's filter
		 *
		 * @param integer   $id id of the filter
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return void
		 */
		public static function deleteWorkshopFilters($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM workshop_filters WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);

			$statement->execute();
		}

		/**
		 * Select all filters of a workshops
		 * 		ex : grade required, difficulty, etc.
		 *
		 * @param integer   $id_workshop id of the workshops you wanna see the filters
		 *
		 * @author Ludovic Doutre-Guay <ludovicdguay@gmail.com>
		 * @return Array return all information about the workshop's filters
		 */
		public static function getWorkshopFilters($id_workshop)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshop_filters WHERE id_workshop = ?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_workshop);
			$statement->execute();

			$content = null;

			while($row = $statement->fetch())
			{
				$content[$row["id_type"]][$row["id_filter"]] = $row;
			}
			return $content;
		}


		public static function getGradesEN()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME,AGE FROM scholar_level");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
				// $content[$row["ID"]] = $row;
			}

			return $content;
		}

		public static function getGradesFR()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME,AGE FROM scholar_level");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				// $content[$row["ID"]] = $row;
				$content[] = $row;
			}

			return $content;
		}

		public static function getGradeById($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME,AGE FROM scholar_level WHERE id = ?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
				// $content[$row["ID"]] = $row;
			}

			return $content;
		}

		public static function getDifficultiesFR()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME FROM difficulty");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
				//$content[$row["ID"]] = $row;
			}

			return $content;
		}
		public static function getDifficultiesEN()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_EN as NAME FROM difficulty");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				//$content[$row["ID"]] = $row;
				$content[] = $row;
			}

			return $content;
		}
		public static function getWorkshopStatesFR()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME FROM workshop_statut");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["ID"]] = $row;
			}

			return $content;
		}
		public static function getWorkshopStatesEN()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_EN as NAME FROM workshop_statut");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["ID"]] = $row;
			}

			return $content;
		}
		public static function getFilterTypeIdByName($name)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT id FROM filter_type WHERE name=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);

			$statement->execute();

			$content = 0;

			if ($row = $statement->fetch()) {
				$content = $row["id"];
			}

			return $content;
		}

	}