<?php

	class ValidationController
	{
		private $dbconn;
		private $table;

		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
	
		function updateActivation($ID)
		{
			$sql = 'UPDATE User SET activated=:value WHERE userId=:ID;';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':ID', $ID );	
			$stmt->bindValue( ':value', '1');
			$stmt->execute();	
		}
		
		function getUserEmail($ID)
		{
			//sql SELECT statement
			$sql = 'SELECT email FROM User WHERE userId=:ID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':ID', $ID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[email]);
		}	
		
		function getSchoolID($ID)
		{
			//sql SELECT statement
			$sql = 'SELECT schoolID FROM User WHERE userId=:ID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':ID', $ID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[schoolID]);
		}
	}
	
	$ID = $_GET['id'];
	$valid = new ValidationController('User');
	$valid->updateActivation($ID);
	$email = $valid->getUserEmail($ID);
	$schoolID = $valid->getSchoolID($ID);
	session_save_path("/home/users/web/b2942/ipg.campusloops/sessions");
	session_start();
	$_SESSION['loggedin'] = "yes";
	$_SESSION['email'] = $email;
	$_SESSION['schoolID'] = $schoolID;
	//header('Location: http://campusloops.com/home.php');
?>