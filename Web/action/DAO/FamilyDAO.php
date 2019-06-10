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
		public static function deleteFamilyMember($id)
		{
			$password = password_hash($password, PASSWORD_BCRYPT);
			$connection = Connection::getConnection();
			$statement = $connection->prepare("DELETE FROM family WHERE id = ?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}
		public static function updateFamilyMember($id,$firstname,$lastname,$birthday,$gender,$id_avatar)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE family SET(firstname=?,lastname=?,birthday=?,gender_id=?,id_avatar=?) WHERE id=?");

			$statement->bindParam(1, $firstname);
			$statement->bindParam(2, $lastname);
			$statement->bindParam(3, $birthday);
			$statement->bindParam(4, $gender);
			$statement->bindParam(5, $id_avatar);
			$statement->bindParam(6, $id);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}

		public static function selectFamilyMembers($id_parent)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT firstname,lastname,birthday,gender_id,id_avatar,id_user,id,score FROM FAMILY WHERE id_user=?");
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
			$statement = $connection->prepare("SELECT ID,NAME,PATH FROM AVATAR");

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$contents[$row["ID"]] = $row;
			}
			return $contents;
		}
	}
