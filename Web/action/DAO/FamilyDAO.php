<?php
	require_once("action/DAO/Connection.php");

	class FamilyDAO {

		public static function insertFamilyMember($firstname,$lastname,$birthday,$gender,$id_avatar,$id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO family(firstname,lastname,birthday,id_gender,id_avatar,id_user) VALUES(?,?,STR_TO_DATE(?, '%d/%m/%Y') ,?,?,?)");

			$statement->bindParam(1, $firstname);
			$statement->bindParam(2, $lastname);
			$statement->bindParam(3, $birthday);
			$statement->bindParam(4, $gender);
			$statement->bindParam(5, $id_avatar);
			$statement->bindParam(6, $id_parent);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}

		public static function addScore($id,$newPts)
		{
			$connection = Connection::getConnection();
			$statementMember = $connection->prepare("SELECT SCORE FROM family WHERE ID=?");

			$statementMember->bindParam(1, $id);

			$statementMember->setFetchMode(PDO::FETCH_ASSOC);
			$statementMember->execute();

			if($row = $statementMember->fetch())
			{
				$score = $row["SCORE"] + $newPts;

				$statementScore = $connection->prepare("UPDATE family SET score=? WHERE id=?");
				$statementScore->bindParam(1, $score);
				$statementScore->bindParam(2, $id);
				$statementScore->execute();

			}
		}
		public static function deleteFamilyMember($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM family WHERE id = ?");
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
		public static function updateFamilyMember($id,$firstname,$lastname,$birthday,$gender,$id_avatar)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE family SET firstname=?,lastname=?,birthday=STR_TO_DATE(?, '%d/%m/%Y'),id_gender=?,id_avatar=? WHERE id=?");

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
			$statement = $connection->prepare("SELECT ID,firstname,lastname,DATE_FORMAT(birthday,'%d/%m/%Y') birthday,id_gender,id_avatar,id_user,id,score FROM family WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;
		}
		public static function getFamilyLikeName($name,$type)
		{
			$connection = Connection::getConnection();
			$name = $name . '%';

			$request = "SELECT id,firstname,lastname,birthday,id_gender,id_avatar,id_user,id,score FROM family ";
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
				$contents[$row["id"]] = $row[$type];
			}

			return $content;
		}

		public static function selectMembersFromIdArray($ids)
		{
			$connection = Connection::getConnection();

			$request = "SELECT id,firstname,lastname,birthday,id_gender,id_avatar,id_user,id,score FROM family WHERE id IN ('$ids')";
			$statement = $connection->prepare();

			$statement->bindParam(1, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$contents[] = $row;
			}

			return $content;
		}

		public static function selectFamilyMembers($id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,firstname,lastname,birthday,id_gender,id_avatar,id_user,id,score FROM family WHERE id_user=? ORDER BY birthday DESC");

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
			$statement = $connection->prepare("SELECT ID,NAME,PATH FROM avatar");

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$contents[$row["ID"]] = $row;
			}
			return $contents;
		}

		public static function getUsers()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID, EMAIL, FIRSTNAME, LASTNAME FROM users");
			$statement->bindParam(1, $id_user);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$temp = [];
				$temp["USER"] = $row;

				$statement2 = $connection->prepare("SELECT ID, FIRSTNAME, LASTNAME, BIRTHDAY, SCORE, ID_AVATAR, id_gender FROM family WHERE id_user = ?");
				$statement2->bindParam(1, $row["ID"]);

				$statement2->setFetchMode(PDO::FETCH_ASSOC);
				$statement2->execute();

				$family = [];
				while ($rowFam = $statement2->fetch()) {
					$family[] = $rowFam;
				}
				$temp["FAMILY"] = $family;
				$contents[] = $temp;
			}
			return $contents;
		}
		public static function getUserFamily($id_user)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID, EMAIL, FIRSTNAME, LASTNAME FROM users WHERE id=?");
			$statement->bindParam(1, $id_user);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$temp = [];
				$temp["USER"] = $row;

				$statement2 = $connection->prepare("SELECT ID, FIRSTNAME, LASTNAME, BIRTHDAY, SCORE, ID_AVATAR, id_gender FROM family WHERE id_user = ?");
				$statement2->bindParam(1, $row["ID"]);

				$statement2->setFetchMode(PDO::FETCH_ASSOC);
				$statement2->execute();

				$family = [];
				while ($rowFam = $statement2->fetch()) {
					$family[] = $rowFam;
				}
				$temp["FAMILY"] = $family;
				$contents[] = $temp;
			}
			return $contents;
		}
	}
