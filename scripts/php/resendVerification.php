<?php
	
	class ValidateClass
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
		
	}
	
	$email = $_POST['email'];
	$validate = new ValidateClass('User');
	$subject = 'Campus Loops Validation';
	$headers = "From: noreply@campusloops.com \r\n";
	$ID = $validate->getUserID($email);
	$emailMessage = 'Click on the link to validate your Campus Loops account.  http://campusloops.com/validation.php?id=' . $ID;
	mail($email, $subject, $emailMessage, $headers);
	header('Location: http://campusloops.com/validate.php?error=2');
?>