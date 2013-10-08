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
			$sql = 'SELECT firstName,lastName,avatar FROM ' . $this->tablename  . ' WHERE userId=:userId;';
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
			$sql = 'SELECT userId,avatar FROM ' . $this->tablename . ' WHERE email="' . $email . '"';
			$result = $this->dbconn->query( $sql );
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			
			// returns userId
			return($entry);
		}
	}
?>