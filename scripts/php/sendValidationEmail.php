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
	
	$ID = $_POST['sendID'];
	$validate = new ValidateClass('User');
	$subject = 'Campus Loops Validation';
	$headers = "From: noreply@campusloops.com \r\n";
	$email = $validate->getUserEmail($ID);
	$emailMessage = 'Click on the link to validate your Campus Loops account.  http://campusloops.com/validation.php?id=' . $ID;
	mail($email, $subject, $emailMessage, $headers);
	header('Location: http://campusloops.com/validate.php?error=2');
?>