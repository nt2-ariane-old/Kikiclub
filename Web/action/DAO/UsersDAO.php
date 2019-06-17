<?php
	require_once("action/DAO/Connection.php");

	class UsersDAO {

		public static function UserExist($email)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM USERS WHERE email=?");
			$statement->bindParam(1, $email);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$exist = false;

			if ($row = $statement->fetch()) {
				$exist = true;
			}
			return $exist;

		}

		public static function getUsersLikeName($name)
		{
			$connection = Connection::getConnection();
			$name = '%'.$name.'%';
			$statement = $connection->prepare("SELECT ID,FIRSTNAME,LASTNAME,EMAIL FROM USERS WHERE EMAIL LIKE ? OR FIRSTNAME LIKE ? OR LASTNAME LIKE ?");
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $name);
			$statement->bindParam(3, $name);
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
		public static function selectUser($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM USERS WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;

		}
		public static function login($email, $password)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,FIRSTNAME,LASTNAME,EMAIL,VISIBILITY,PASSWORD FROM USERS WHERE email = ?");
			$statement->bindParam(1, $email);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$infos = null;

			if ($row = $statement->fetch()) {
				if($row["PASSWORD"] != null){
					if (password_verify($password, $row["PASSWORD"])) {
						$infos = $row;
					} else
					{
						$infos = null;
					}
				} else {
					$infos = $row;
				}
			}

			return $infos;
		}
		public static function registerUser($email,$password,$firstname,$lastname,$visibility)
		{
			$password = password_hash($password, PASSWORD_BCRYPT);
			$connection = Connection::getConnection();
			$statement = $connection->prepare("INSERT INTO USERS(email,password,firstname,lastname,visibility) VALUES(?,?,?,?,?)");
			$statement->bindParam(1, $email);
			$statement->bindParam(2, $password);
			$statement->bindParam(3, $firstname);
			$statement->bindParam(4, $lastname);
			$statement->bindParam(5, $visibility);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

		}
		public static function updateUser($id,$email,$firstname,$lastname)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE USERS SET email=?,firstname=?,lastname=? WHERE id=?");
			$statement->bindParam(1, $email);
			$statement->bindParam(2, $firstname);
			$statement->bindParam(3, $lastname);
			$statement->bindParam(4, $id);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
	}
