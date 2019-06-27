<?php
	require_once("action/DAO/Connection.php");

	class FamilyDAO {

		public static function insertFamilyMember($firstname,$lastname,$birthday,$gender,$id_avatar,$id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO family(firstname,lastname,birthday,gender_id,id_avatar,id_user) VALUES(?,?,STR_TO_DATE(?, '%d/%m/%Y') ,?,?,?)");

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
			$statement = $connection->prepare("UPDATE family SET firstname=?,lastname=?,birthday=STR_TO_DATE(?, '%d/%m/%Y'),gender_id=?,id_avatar=? WHERE id=?");

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
			$statement = $connection->prepare("SELECT ID,firstname,lastname,DATE_FORMAT(birthday,'%d/%m/%Y') birthday,gender_id,id_avatar,id_user,id,score FROM family WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;
		}
		public static function getFamilyLikeName($name)
		{
			$connection = Connection::getConnection();
			$name = '%' . $name . '%';
			$statement = $connection->prepare("SELECT ID,firstname,lastname,birthday,gender_id,id_avatar,id_user,id,score FROM family WHERE firstname LIKE ? OR lastname LIKE ?");

			$statement->bindParam(1, $name);
			$statement->bindParam(2, $name);
			$statement->bindParam(3, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content[] = $row;
			}

			return $content;
		}
		public static function selectFamilyMembers($id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID,firstname,lastname,birthday,gender_id,id_avatar,id_user,id,score FROM family WHERE id_user=? ORDER BY birthday DESC");

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

				$statement2 = $connection->prepare("SELECT ID, FIRSTNAME, LASTNAME, BIRTHDAY, SCORE, ID_AVATAR, GENDER_ID FROM family WHERE id_user = ?");
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
			$statement2->bindParam(1, $id_user);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$temp = [];
				$temp["USER"] = $row;

				$statement2 = $connection->prepare("SELECT ID, FIRSTNAME, LASTNAME, BIRTHDAY, SCORE, ID_AVATAR, GENDER_ID FROM family WHERE id_user = ?");
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
