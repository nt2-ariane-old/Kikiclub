<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/Connection.php");

	class WorkshopDAO {

		public static function getWorkshops($orderby="none",$ascendant=false, $deployed=true, $page=-1) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();


			$request = "SELECT * FROM workshops ";


			if($deployed)
			{
				$request .= "WHERE deployed = TRUE ";
			}
			else
			{
				$request .= "WHERE deployed = FALSE ";
			}

			if($orderby != "none")
			{
				if($orderby == "NAME")
				{
					$request .= "ORDER BY NAME ";
				}
				else if($orderby == "ID")
				{
					$request .= "ORDER BY ID ";
				}

				if($ascendant)
				{
					$request .= "ASC ";
				}
				else
				{
					$request .= "DESC ";
				}
			}
			if($page >= 0)
			{
				$request .= " LIMIT ?,12";
			}
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);

			if($page >= 0)
			{
				$limit = $page * 12;
				$statement->bindParam(1, $limit);

			}
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}
			return $content;
		}

		public static function getNbWorkshops($deployed=true)
		{
			$connection = Connection::getConnection();
			$request = "SELECT COUNT(*) AS nb FROM workshops ";
			if($deployed)
			{
				$request .= "WHERE deployed=TRUE ";
			}
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = null;
			if($row = $statement->fetch())
			{
				$content = $row["nb"];
			}
			return $content;
		}
		public static function setDeployed($id,$deployed)
		{
			$connection = Connection::getConnection();
			$request = "UPDATE workshops SET ";
			if($deployed == "true")
			{
				$request .= "deployed=TRUE ";
			}
			else
			{
				$request .= "deployed=FALSE ";
			}
			$request.="WHERE id=?";
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
		public static function getWorkshopsLikeName($name, $deployed=true) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();
			$name = '%' . $name . '%';

			$request = "SELECT * FROM workshops WHERE NAME LIKE ? ";
			if($deployed)
			{
				$request .= "AND deployed = TRUE";
			}
			$statement = $connection->prepare($request);
			$statement->bindParam(1, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function getWorkshopsWithID($id) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,DEPLOYED,ID_ROBOT,ID_DIFFICULTY,ID_GRADE FROM workshops WHERE ID=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content = $row;
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
		public static function searchWorkshops($request=null, $value=null)
		{

			$connection = Connection::getConnection();
			if($request == "difficulty")
			{
				$statement = $connection->prepare("SELECT * FROM workshops WHERE ID_DIFFICULTY=?  AND deployed = TRUE");
				$statement->bindParam(1, $value);
			}
			else
			{
				$statement = $connection->prepare("SELECT * FROM workshops WHERE deployed = TRUE");
			}
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
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
		public static function getGradesEN()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME FROM scholar_level");
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
			$statement = $connection->prepare("SELECT ID,NAME_FR as NAME FROM scholar_level");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				// $content[$row["ID"]] = $row;
				$content[] = $row;
			}

			return $content;
		}


		public static function addWorkshop($name, $content, $MEDIA_PATH, $MEDIA_TYPE,$deploy){
			$connection = Connection::getConnection();
			$request = "INSERT INTO workshops(NAME,CONTENT,MEDIA_PATH, MEDIA_TYPE,DEPLOYED) VALUES (?,?,?,?,";
			if($deploy)
			{
				$request .= "TRUE";
			}
			else
			{
				$request .= "FALSE";
			}
			$request .= ")";
			$statement = $connection->prepare($request);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $MEDIA_PATH);
			$statement->bindParam(4, $MEDIA_TYPE);

			$statement->execute();
		}
		public static function updateWorkshop($id,$name, $content, $MEDIA_PATH, $MEDIA_TYPE){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("UPDATE workshops SET NAME=?,CONTENT=?,MEDIA_PATH=? , MEDIA_TYPE=? WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);
			$statement->bindParam(3, $MEDIA_PATH);
			$statement->bindParam(4, $MEDIA_TYPE);
			$statement->bindParam(5, $id);
			$statement->execute();
		}
		public static function deleteWorkshop($id){
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM workshops WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);
			$statement->execute();
		}

		public static function getWorkshopByNameAndContent($name,$content)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE NAME=? AND CONTENT=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $content);

			$statement->execute();

			$content = [];

			if ($row = $statement->fetch()) {
				$content= $row;
			}

			return $content;
		}

		public static function getFilterTypeIdByName($name)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID FROM filter_type WHERE NAME=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $name);

			$statement->execute();

			$content = 0;

			if ($row = $statement->fetch()) {
				$content = $row["ID"];
			}

			return $content;
		}
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
		public static function deleteWorkshopFilters($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM workshop_filters WHERE id=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id);

			$statement->execute();
		}
		public static function selectWorkshopFilters($id_workshop)
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
		public static function selectMemberWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM family_workshops WHERE ID_MEMBER=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[$row["ID_WORKSHOP"]] = $row;
			}

			return $content;
		}
		public static function selectMemberNotStartedWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE ID NOT IN (SELECT ID_WORKSHOP FROM family_workshops WHERE ID_MEMBER=? AND ID_STATUT != 1 AND ID_STATUT != 2)  AND deployed = TRUE");

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function selectMemberNewWorkshop($id_member)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE ID NOT IN (SELECT ID_WORKSHOP FROM family_workshops WHERE ID_MEMBER=? AND ID_STATUT != 1 )  AND deployed = TRUE");

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

			$statement = $connection->prepare("INSERT INTO family_workshops(ID_MEMBER, ID_WORKSHOP, ID_STATUT) VALUES (?,?,?)");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $id_member);
			$statement->bindParam(2, $id_workshop);
			$statement->bindParam(3, $statut);
			$statement->execute();
		}
		public static function updateMemberWorkshop($id_member,$id_workshop, $statut)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE family_workshops SET ID_STATUT = ?, LAST_MODIFICATION=CURRENT_TIMESTAMP WHERE ID_MEMBER = ? AND ID_WORKSHOP=?");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->bindParam(1, $statut);
			$statement->bindParam(2, $id_member);
			$statement->bindParam(3, $id_workshop);
			$statement->execute();
		}
		public static function selectWorkshop($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM workshops WHERE id=?");
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

			$statement = $connection->prepare("SELECT ID, QUESTION, ANSWER FROM workshops_question WHERE id_workshop=?");
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
