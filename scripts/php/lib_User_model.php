<?php
	class UserController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}

		function getName($userId){
			$sql = 'SELECT firstName,lastName,avatar,userClass FROM ' . $this->tablename  . ' WHERE userId=:userId;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':userId', $userId);
			$result->execute();
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function getUserId($email){
			$sql = 'SELECT userId FROM ' . $this->tablename  . ' WHERE email=:email;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':email', $email); 
			$statement->execute();
			$entry = $statement->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function getUserInfo($email)
		{
			// SQL Query gets the user's id via there email
			$sql = 'SELECT userId,firstName,lastName,avatar,userClass,birthDate,facebook,twitter,instagram,linkedIn,tumblr,activated,schoolID FROM ' . $this->tablename . ' WHERE email=:id';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':id', $email);
			$result->execute();
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			// returns userId
			return($entry);
		}
		
		function searchByFirstName($search){
			$sql = 'SELECT userId, firstName, lastName FROM ' . $this->tablename . ' WHERE firstName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchByLastName($search){
			$sql = 'SELECT userId, firstName, lastName FROM ' . $this->tablename . ' WHERE lastName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchByBothNames($search, $search2){
			$sql = 'SELECT userId, firstName, lastName FROM ' . $this->tablename . ' WHERE firstName LIKE :search AND lastName LIKE :search2;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->bindValue(':search2', $search2);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchByEmail($search){
			$sql = 'SELECT userId, firstName, lastName FROM ' . $this->tablename . ' WHERE email LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchAll($search){
			$sql = 'SELECT userId, firstName, lastName FROM ' . $this->tablename . ' WHERE email LIKE :search OR firstName LIKE :search1 OR lastName LIKE :search2;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->bindValue(':search1', $search);
			$statement->bindValue(':search2', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
	
?>