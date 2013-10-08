<?php

	class SendController
	{
		private $dbconn;
		private $table;

		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function getUserID($email)
		{
			//sql SELECT statement
			$sql = 'SELECT userId FROM User WHERE email=:email;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':email', $email );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[userId]);
		}
		
		function addRequest($userID)
		{
			$sql = 'INSERT INTO `passChange` ( `userID` ) VALUES (:userID);';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userID', $userID );
			$stmt->execute();	
		}
	
	}	
	
	$sendController = new SendController('User');
	$email = $_POST['email'];
	$ID = $sendController->getUserID($email);
	$sendController->addRequest($ID);
	$subject = 'Campus Loops Validation';
	$headers = "From: noreply@campusloops.com \r\n";
	$emailMessage = 'Click on the link to change you Campus Loops password.  http://campusloops.com/changed.php?id=' . $ID;
	mail($email, $subject, $emailMessage, $headers);
	header('Location: http://campusloops.com/info.php?email=sent');
	
?>