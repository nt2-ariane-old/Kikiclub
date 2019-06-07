<?php
	require_once("action/DAO/Connection.php");

	class UsersDAO {

		//PAGE

		public static function getParent($email) { //RECEVOIR TOUTES LES PAGES
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT ID,NAME,SCORE FROM PARENTS WHERE EMAIL=?");
			$statement->bindParam(1, $email);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$content = [];

			while ($row = $statement->fetch()) {
				$content = $row;
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
	}
