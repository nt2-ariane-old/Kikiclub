<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/action/DAO/Connection.php");

	class UsersDAO {

		public static function getAllUsers()
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM users");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$contents[] = $row;
			}
			return $contents;
		}

		public static function getUsersLikeType($value,$type)
		{
			$connection = Connection::getConnection();
			$value = $value.'%';
			$request = "SELECT * FROM users ";
			if($type == 'firstname')
			{
				$request .= "WHERE firstname LIKE ?";
			}
			else if ($type == 'lastname')
			{
				$request .= "WHERE lastname LIKE ?";
			}
			else if ($type == 'email')
			{
				$request .= "WHERE email LIKE ?";
			}

			$statement = $connection->prepare($request);
			$statement->bindParam(1, $value);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$temp["label"] = $row[$type];
				$temp["value"] = $row["id"];
				$contents[] = $temp;
			}

			return $contents;
		}

		public static function getUserWithID($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM users WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;

		}

		public static function getUserWithEmail($email)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT * FROM users WHERE email=?");
			$statement->bindParam(1, $email);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;
		}

		public static function loginUserWithEmail($email, $password, $id_type)
		{
			$connection = Connection::getConnection();

			$statementUser = $connection->prepare("SELECT * FROM users WHERE email = ?");
			$statementUser->bindParam(1, $email);
			$statementUser->setFetchMode(PDO::FETCH_ASSOC);
			$statementUser->execute();

			$infos = null;

			if ($rowUser = $statementUser->fetch()) {
				$rowLogin = UsersDAO::getLoginInfosForUserByType($rowUser["id"],$id_type);
				if (!empty($rowLogin)) {
					$rowLoginType = UsersDAO::getLoginTypeById($rowLogin["id_login_type"]);
					if(!empty($rowLoginType))
					{
						switch ($rowLoginType["name"]) {
							case 'Facebook':
								$infos = $rowUser;
								break;
							case 'Google':
								$infos = $rowUser;
								break;
							case 'Wix':
								$infos = $rowUser;
								break;
							case 'Kikiclub':
								if (password_verify($password,$rowLogin["password"]))
								{
									$infos = $rowUser;
								}
								else {
									$infos = "Invalid Password";
								}
								break;
						}
					}

				}
				else
				{
					$infos = "Invalid Method of Connection.";
				}
			}
			else
			{
				$infos = "Invalid Email. Please Register";
			}

			return $infos;
		}

		public static function getAllLoginType()
		{
			$connection = Connection::getConnection();

			$statement= $connection->prepare("SELECT * FROM login_type");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			while ($row = $statement->fetch()) {
				$contents[] = $row;
			}
			return $contents;
		}
		public static function setTokenForUser($id_user,$token)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO connect_token (id_user,token) VALUES (?,?)");
			$statement->bindParam(1, $id_user);
			$statement->bindParam(2, $token);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function deleteToken($token)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM connect_token WHERE token=?");
			$statement->bindParam(1, $token);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function deleteUser($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("DELETE FROM users WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function getUserFromToken($token)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT id_user FROM connect_token WHERE token=?");
			$statement->bindParam(1, $token);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$id = null;
			if($row = $statement->fetch())
			{
				$id = $row["id_user"];
			}
			return $id;
		}
		public static function getLoginTypeIdByName($name)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT id FROM login_type WHERE NAME=?");
			$statement->bindParam(1, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$id = null;

			if ($row = $statement->fetch()) {
				$id = $row["id"];
			}
			return $id;
		}

		public static function getLoginTypeById($id)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("SELECT * FROM login_type WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}

			return $contents;
		}

		public static function addLoginInfosForUser($id_user,$id_type,$password)
		{
			$connection = Connection::getConnection();

			$statementLogin = $connection->prepare("INSERT INTO users_login(id_user,id_login_type,password) VALUES (?,?,?)");
			$statementLogin->bindParam(1, $id_user);
			$statementLogin->bindParam(2, $id_type);
			$statementLogin->bindParam(3, $password);
			$statementLogin->setFetchMode(PDO::FETCH_ASSOC);
			$statementLogin->execute();
		}
		public static function getLoginInfosForUserByType($id_user,$id_type)
		{
			$connection = Connection::getConnection();

			$statementLogin = $connection->prepare("SELECT * FROM users_login WHERE id_user=? AND id_login_type =?");
			$statementLogin->bindParam(1, $id_user);
			$statementLogin->bindParam(2, $id_type);
			$statementLogin->setFetchMode(PDO::FETCH_ASSOC);
			$statementLogin->execute();

			$contents = [];
			if($row = $statementLogin->fetch())
			{
				$contents = $row;
			}
			return $contents;
		}

		public static function addUser($email,$firstname,$lastname,$visibility,$token)
		{
			$connection = Connection::getConnection();

			$statement = $connection->prepare("INSERT INTO users(email,firstname,lastname,visibility,token) VALUES(?,?,?,?,?)");
			$statement->bindParam(1, $email);
			$statement->bindParam(2, $firstname);
			$statement->bindParam(3, $lastname);
			$statement->bindParam(4, $visibility);
			$statement->bindParam(5, $token);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}

		public static function registerUser($email,$password, $password_confirm,$firstname,$lastname,$visibility,$id_type,$token)
		{

			$connection = Connection::getConnection();

			$valide = false;
			if(empty(UsersDAO::getUserWithEmail($email)))
			{
				$valide = true;
				UsersDAO::addUser($email,$firstname,$lastname,$visibility,$token);
			}
			else
			{
				$user = UsersDAO::getUserWithEmail($email);
				if(empty(UsersDAO::getLoginInfosForUserByType($user["id"],$id_type)))
				{
					$valide = true;
				}
			}

			if($id_type == UsersDAO::getLoginTypeIdByName("Kikiclub"))
			{
				if(!empty($password))
				{
					if($password === $password_confirm)
					{
						$password = password_hash($password, PASSWORD_BCRYPT);
					}
					else
					{
						$password = null;
						$valide = false;
					}
				}
			}

			if(!empty($id_type) && $valide)
			{
				$user = UsersDAO::getUserWithEmail($email);
				UsersDAO::addLoginInfosForUser($user["id"],$id_type,$password);
			}

			return $valide;
		}
		public static function updateUser($id,$email,$firstname,$lastname,$visibility)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE users SET email=?,firstname=?,lastname=?,visibility=? WHERE id=?");
			$statement->bindParam(1, $email);
			$statement->bindParam(2, $firstname);
			$statement->bindParam(3, $lastname);
			$statement->bindParam(4, $visibility);
			$statement->bindParam(5, $id);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
	}
