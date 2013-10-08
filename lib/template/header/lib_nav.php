<?php
	
	// class to get UserId via email
	class UserInfoController
	{
		private $dbconn;
		private $tablename;
		
		// constructor takes in a tablename, and defaults to our database
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		// gets userId via email
		function getUserInfo($email)
		{
			// SQL Query gets the user's id via there email
			$sql = 'SELECT userId,firstName,lastName,avatar,facebook,twitter,instagram,linkedin,tumblr,birthDate FROM ' . $this->tablename . ' WHERE email="' . $email . '"';
			$result = $this->dbconn->query( $sql );
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			
			// returns userId
			return($entry);
		}
	}
	
?>