<?php
	require_once("action/DAO/Connection.php");

	class UsersDAO {

		public static function getAllUsers($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID, FIRSTNAME,LASTNAME,EMAIL FROM users WHERE id=?");
			$statement->bindParam(1, $id);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();

			$contents = [];

			if ($row = $statement->fetch()) {
				$contents = $row;
			}
			return $contents;

		}
		
		public static function getUsersLikeName($name)
		{
			$connection = Connection::getConnection();
			$name = '%'.$name.'%';
			$statement = $connection->prepare("SELECT ID,FIRSTNAME,LASTNAME,EMAIL FROM users WHERE EMAIL LIKE ? OR FIRSTNAME LIKE ? OR LASTNAME LIKE ? OR CONCAT(FIRSTNAME,' ', LASTNAME) LIKE ?");
			$statement->bindParam(1, $name);
			$statement->bindParam(2, $name);
			$statement->bindParam(3, $name);
			$statement->bindParam(4, $name);

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
		
		public static function getUserWithID($id)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("SELECT ID, FIRSTNAME,LASTNAME,EMAIL FROM users WHERE id=?");
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
			$statement = $connection->prepare("SELECT ID, FIRSTNAME,LASTNAME,EMAIL FROM users WHERE email=?");
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

			$statementUser = $connection->prepare("SELECT ID,FIRSTNAME,LASTNAME,EMAIL,VISIBILITY FROM users WHERE email = ?");
			$statementUser->bindParam(1, $email);
			$statementUser->setFetchMode(PDO::FETCH_ASSOC);
			$statementUser->execute();

			$infos = null;

			if ($rowUser = $statementUser->fetch()) {
				$rowLogin = UsersDAO::getLoginInfosForUserByType($rowUser["ID"],$id_type);
				if (!empty($rowLogin)) {
					$rowLoginType = UsersDAO::getLoginTypeById($rowLogin["ID_LOGIN_TYPE"]);
					if(!empty($rowLoginType))
					{
						switch ($rowLoginType["NAME"]) {
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
								if (password_verify($password,$rowLogin["PASSWORD"]))
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
			
			$statement= $connection->prepare("SELECT ID,NAME FROM login_type");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			
			$contents = [];
			
			while ($row = $statement->fetch()) {
				$contents[] = $row;	
			}
			return $contents;
		}
		public static function getLoginTypeIdByName($name)
		{
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("SELECT ID FROM login_type WHERE NAME=?");
			$statement->bindParam(1, $name);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			
			$id = -1;
			
			if ($row = $statement->fetch()) {
				$id = $row["ID"];	
			}
			return $id;
		}
		
		public static function getLoginTypeById($id)
		{
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("SELECT ID,NAME FROM login_type WHERE ID=?");
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

			$statementLogin = $connection->prepare("INSERT INTO users_login(ID_USER,ID_LOGIN_TYPE,PASSWORD) VALUES (?,?,?)");
			$statementLogin->bindParam(1, $id_user);
			$statementLogin->bindParam(2, $id_type);
			$statementLogin->bindParam(3, $password);
			$statementLogin->setFetchMode(PDO::FETCH_ASSOC);
			$statementLogin->execute();
		}
		public static function getLoginInfosForUserByType($id_user,$id_type)
		{
			$connection = Connection::getConnection();
			
			$statementLogin = $connection->prepare("SELECT ID_USER,ID_LOGIN_TYPE,PASSWORD FROM users_login WHERE ID_USER=? AND ID_LOGIN_TYPE =?");
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
		
		public static function addUser($email,$firstname,$lastname,$visibility)
		{
			$connection = Connection::getConnection();
			
			$statement = $connection->prepare("INSERT INTO users(email,firstname,lastname,visibility) VALUES(?,?,?,?)");
			$statement->bindParam(1, $email);
			$statement->bindParam(2, $firstname);
			$statement->bindParam(3, $lastname);
			$statement->bindParam(4, $visibility);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
		
		public static function registerUser($email,$password, $password_confirm,$firstname,$lastname,$visibility,$id_type)
		{
			
			$connection = Connection::getConnection();

			$valide = false;
			if(empty(UsersDAO::getUserWithEmail($email)))
			{
				$valide = true;
				UsersDAO::addUser($email,$firstname,$lastname,$visibility);
			}
			else
			{
				$user = UsersDAO::getUserWithEmail($email);
				if(empty(UsersDAO::getLoginInfosForUserByType($user["ID"],$id_type)))
				{
					$valide = true;
				}
			}

			if(!empty($password) && $id_type == UsersDAO::getLoginTypeIdByName("Kikiclub"))
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
			
			if(!empty($id_type) && $valide)
			{
				$user = UsersDAO::getUserWithEmail($email);	
				UsersDAO::addLoginInfosForUser($user["ID"],$id_type,null);
			}

			return $valide;
		}
		public static function updateUser($id,$email,$firstname,$lastname)
		{
			$connection = Connection::getConnection();
			$statement = $connection->prepare("UPDATE users SET email=?,firstname=?,lastname=? WHERE id=?");
			$statement->bindParam(1, $email);
			$statement->bindParam(2, $firstname);
			$statement->bindParam(3, $lastname);
			$statement->bindParam(4, $id);

			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
		}
	}
