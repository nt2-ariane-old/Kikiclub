<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/Connection.php");

	class RobotDAO {

		public static function getRobots()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM robot");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				//$content[$row["ID"]] = $row;
				$content[] = $row;
			}

			return $content;
		}

		public static function deleteRobot($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM robot WHERE ID=?");
			$statement->bindParam(1, $id);
			$statement->execute();
		}
		public static function insertRobot($name,$gradeRecommanded)
		{
			$connection = Connection::getConnection();
			$statementRobots = $connection->prepare("INSERT INTO robot(NAME,ID_GRADE) VALUES (?,?)");
			$statementRobots->bindParam(1, $name);
			$statementRobots->bindParam(2, $gradeRecommanded);

			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();
		}
		public static function updateRobot($id,$name,$gradeRecommanded)
		{
			$connection = Connection::getConnection();
			$statementRobots = $connection->prepare("UPDATE robot SET NAME=?,ID_GRADE=? WHERE ID=?");
			$statementRobots->bindParam(1, $name);
			$statementRobots->bindParam(2, $gradeRecommanded);
			$statementRobots->bindParam(3, $id);

			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();
		}
		public static function getRobotsAndDifficultiesByNAME($name)
		{
			$name = '%'.$name.'%';
			$connection = Connection::getConnection();
			$statementRobots = $connection->prepare("SELECT * FROM robot WHERE name LIKE ?");
			$statementRobots->bindParam(1, $name);
			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();

			$content = [];

			while ($row = $statementRobots->fetch()) {
				$temp = [] ;
				$temp["ROBOTS"] = $row;
				$temp["SCORES"] = RobotDAO::getDifficultyScoresForRobot($row["ID"]);
				$content[] = $temp;
			}

			return $content;
		}

		public static function getRobotsAndDifficultiesByID($id)
		{
			$connection = Connection::getConnection();
			$statementRobots = $connection->prepare("SELECT * FROM robot WHERE id = ?");
			$statementRobots->bindParam(1, $id);
			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();

			$content = [];

			if ($row = $statementRobots->fetch()) {
				$content["ROBOTS"] = $row;
				$content["SCORES"] = RobotDAO::getDifficultyScoresForRobot($row["ID"]);
			}

			return $content;
		}

		public static function getRobotByName($name)
		{
			$connection = Connection::getConnection();
			$statementRobots = $connection->prepare("SELECT * FROM robot WHERE name=?");
			$statementRobots->bindParam(1, $name);
			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();

			$content = [];

			if ($row = $statementRobots->fetch()) {

				$content = $row;
			}

			return $content;
		}
		public static function insertRobotScoreByDifficulty($id_robot,$id_difficulty,$score)
		{
			$connection = Connection::getConnection();

			$statementRobots = $connection->prepare("INSERT INTO workshop_score(id_robot,id_difficulty,score) VALUES (?,?,?)");

			$statementRobots->bindParam(1, $id_robot);
			$statementRobots->bindParam(2, $id_difficulty);
			$statementRobots->bindParam(3, $score);

			$statementRobots->execute();
		}

		public static function updateRobotScoreByDifficulty($id_robot,$id_difficulty,$score)
		{
			$connection = Connection::getConnection();

			$statementRobots = $connection->prepare("UPDATE workshop_score SET score=? WHERE id_robot = ? AND id_difficulty=?");

			$statementRobots->bindParam(1, $score);
			$staatementRobots->bindParam(2, $id_robot);
			$statementRobots->bindParam(3, $id_difficulty);

			$statementRobots->execute();
		}

		public static function getScoreOfRobotByDifficulty($id_robot,$id_difficulty)
		{
			$connection = Connection::getConnection();

			$statementRobots = $connection->prepare("SELECT SCORE FROM workshop_score WHERE ID_ROBOT = ? AND ID_DIFFICULTY = ?");

			$statementRobots->bindParam(1, $id_robot);
			$statementRobots->bindParam(2, $id_difficulty);

			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();

			$score = 0;

			if ($row = $statementRobots->fetch()) {
				$score = $row["SCORE"];
			}

			return $score;
		}
		public static function getDifficultyScoresForRobot($id)
		{
			$connection = Connection::getConnection();

			$statementRobots = $connection->prepare("SELECT d.NAME_EN AS DIFFICULTY, s.ID_DIFFICULTY AS ID_DIFFICULTY, s.SCORE AS SCORE FROM workshop_score AS s INNER JOIN difficulty AS d WHERE s.id_difficulty = d.id AND s.id_robot = ?");

			$statementRobots->bindParam(1, $id);

			$statementRobots->setFetchMode(PDO::FETCH_ASSOC);
			$statementRobots->execute();

			$content = [];

			while ($row = $statementRobots->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

}