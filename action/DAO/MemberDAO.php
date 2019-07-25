<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/Connection.php");

	/**
	 * Access to all filter related informations in the database
	 *
	 * @link       https://doutreguay.com/action/DAO/FilterDAO
	 * @since      Class available since Alpha 1.0.0
	 */
	class MemberDAO {

		public static function insertFamilyMember($firstname,$lastname,$birthday,$gender,$id_avatar,$id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO member(firstname,lastname,birthday,id_gender,id_avatar,id_user) VALUES(?,?,STR_TO_DATE(?, '%d/%m/%Y') ,?,?,?)");

			$statement->bindParam(1, $firstname);
			$statement->bindParam(2, $lastname);
			$statement->bindParam(3, $birthday);
			$statement->bindParam(4, $gender);
			$statement->bindParam(5, $id_avatar);
			$statement->bindParam(6, $id_parent);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}

		public static function searchAllUsersAndMembers($value)
		{
			$connection = Connection::getConnection();
			$value = $value . "%";
			$requestMember = "SELECT id,firstname,lastname FROM member ";
			$requestMember .= "WHERE firstname LIKE ? OR lastname LIKE ? OR CONCAT(firstname,' ',lastname) LIKE ?";

			$statementMember = $connection->prepare($requestMember);
			$statementMember->bindParam(1, $value);
			$statementMember->bindParam(2, $value);
			$statementMember->bindParam(3, $value);
			$statementMember->setFetchMode(PDO::FETCH_ASSOC);
			$statementMember->execute();

			$contents = null;

			while ($row = $statementMember->fetch())
			{

				$temp = [];
				$temp["type"] = "member";
				$temp["label"] = "Member => " . $row["firstname"] . " " . $row["lastname"];
				$temp["value"] = $row["id"];
				$contents[] = $temp;
			}

			$requestUser = "SELECT id,firstname,lastname,email FROM users ";
			$requestUser .= "WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ? OR CONCAT(firstname,' ',lastname) LIKE ?";
			$statementUser = $connection->prepare($requestUser);
			$statementUser->bindParam(1, $value);
			$statementUser->bindParam(2, $value);
			$statementUser->bindParam(3, $value);
			$statementUser->bindParam(4, $value);
			$statementUser->setFetchMode(PDO::FETCH_ASSOC);
			$statementUser->execute();

			while ($row = $statementUser->fetch())
			{
				$temp = [];
				$temp["type"] = "user";
				$temp["label"] = "User => " . $row["firstname"] . " " . $row["lastname"] . " => " . $row["email"];
				$temp["value"] = $row["id"];
				$contents[] = $temp;
			}

			return $contents;

		}

		public static function addScore($id,$newPts)
		{
			$connection = Connection::getConnection();
			$statementMember = $connection->prepare("SELECT SCORE FROM member WHERE ID=?");

			$statementMember->bindParam(1, $id);

			$statementMember->setFetchMode(PDO::FETCH_ASSOC);
			$statementMember->execute();

			if($row = $statementMember->fetch())
			{
				$score = $row["SCORE"] + $newPts;

				$statementScore = $connection->prepare("UPDATE member SET score=? WHERE id=?");
				$statementScore->bindParam(1, $score);
				$statementScore->bindParam(2, $id);
				$statementScore->execute();

			}
		}
		public static function deleteFamilyMember($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM member WHERE id = ?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}

		public static function deleteUsers($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM users WHERE id = ?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}

		public static function getGenders()
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,NAME FROM gender");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = null;
			while($row = $statement->fetch())
			{
				$content[] = $row;
			}
			return $content;
		}

		public static function updateFamilyMember($id,$firstname,$lastname,$birthday,$gender,$id_avatar)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE member SET firstname=?,lastname=?,birthday=STR_TO_DATE(?, '%d/%m/%Y'),id_gender=?,id_avatar=? WHERE id=?");

			$statement->bindParam(1, $firstname);
			$statement->bindParam(2, $lastname);
			$statement->bindParam(3, $birthday);
			$statement->bindParam(4, $gender);
			$statement->bindParam(5, $id_avatar);
			$statement->bindParam(6, $id);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}

		public static function selectMember($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,firstname,lastname,DATE_FORMAT(birthday,'%d/%m/%Y') birthday,id_gender,id_avatar,id_user,id,score FROM member WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;
		}

		public static function getMember($firstname,$lastname,$birth,$id_user)
		{
			$connection = Connection::getConnection();

			$request = "SELECT * FROM member WHERE firstname=? AND lastname=? AND id_user=? AND STR_TO_DATE(?, '%d/%m/%Y')";

			$statement = $connection->prepare($request);

			$statement->bindParam(1, $firstname);
			$statement->bindParam(2, $lastname);
			$statement->bindParam(3, $id_user);
			$statement->bindParam(4, $birth);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = null;

			if($row = $statement->fetch())
			{
				$contents = $row;
			}

			return $contents;
		}
		public static function getFamilyLikeType($name,$type)
		{
			$connection = Connection::getConnection();
			$name = $name . '%';

			$request = "SELECT id,firstname,lastname FROM member ";
			if($type == 'firstname')
			{
				$request .= "WHERE firstname LIKE ?";
			}
			else if ($type == 'lastname')
			{
				$request .= "WHERE lastname LIKE ?";
			}

			$statement = $connection->prepare($request);

			$statement->bindParam(1, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$temp = [];
				$temp["label"] = $row[$type];
				$temp["value"] = $row["id"];
				$content[] = $temp;
			}



			return $content;
		}

		public static function getAllMember()
		{
			$connection = Connection::getConnection();


			$request = "SELECT id FROM member ";

			$statement = $connection->prepare($request);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}



			return $content;
		}
		public static function getAllMemberWithAges($ages)
		{
			$connection = Connection::getConnection();
			$age_str = "";
			for ($i=0; $i < sizeof($ages); $i++) {
				$age = $ages[$i];
				if($i == 0)
				{
					$age_str .= strval($age);

				}
				$age_str .= ',' . strval($age);
			}


			$request = "SELECT id, FLOOR((DATEDIFF(NOW(),BIRTHDAY) / 365)) AS age FROM member WHERE FLOOR((DATEDIFF(NOW(),BIRTHDAY) / 365)) IN( ? )";
			$statement = $connection->prepare($request);
			$statement->bindParam(1,$age_str);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}

		public static function selectMembersFromIdArray($ids)
		{
			$connection = Connection::getConnection();

			$request = "SELECT * FROM member WHERE id IN (?)";
			$statement = $connection->prepare();

			$statement->bindParam(1, $ids);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$contents[] = $row;
			}

			return $content;
		}

		public static function selectFamily($id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM member WHERE id_user=? ORDER BY birthday DESC");

			$statement->bindParam(1, $id_parent);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$contents[] = $row;
			}
			return $contents;
		}

		public static function loadAvatar()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM avatar");

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$contents[$row["ID"]] = $row;
			}
			return $contents;
		}

		public static function getUserFamily($id_user)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM users WHERE id=?");
			$statement->bindParam(1, $id_user);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$temp = [];
				$temp["user"] = $row;

				$statement2 = $connection->prepare("SELECT * FROM member WHERE id_user = ?");
				$statement2->bindParam(1, $row["id"]);

				$statement2->setFetchMode(PDO::FETCH_ASSOC);
				$statement2->execute();

				$member = [];
				while ($rowFam = $statement2->fetch()) {
					$member[] = $rowFam;
				}
				$temp["family"] = $member;
				$contents = $temp;
			}
			return $contents;
		}


	}
