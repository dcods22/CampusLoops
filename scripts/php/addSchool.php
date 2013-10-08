<?php
	
	class AddSchoolController
	{
		private $dbconn;
		private $tablename;
		
		// constructor takes in a tablename, and defaults to our database
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function addSchool($name, $city, $state, $email)
		{
			// build INSERT query string
			$sql = 'INSERT INTO ' . $this->tablename . ' (name, city, state, email, verified, color1, color2, color3) 
					VALUES ( :name, :city, :state, :email, :verified, :color1. :color2, :color3)';
			echo $sql;
			$color1 = 1;
			$color2 = 2;
			$color3 = 3;
			$verified = 1;
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':name', $name );
			$stmt->bindValue( ':city', $city );
			$stmt->bindValue( ':state', $state );
			$stmt->bindValue( ':email', $email );
			$stmt->bindValue( ':verified', $verified );
			$stmt->bindValue( ':color1', $color1 );
			$stmt->bindValue( ':color2', $color2 );
			$stmt->bindValue( ':color3', $color3 );
			$stmt->execute();
		}

	}
	
	$name = $_POST['schoolName'];
	$city = $_POST['schoolCity'];
	$state = $_POST['schoolState'];
	$email = $_POST['schoolEmail'];
	$color1 = $_POST['color1'];
	$color2 = $_POST['color2'];
	$color3 = $_POST['color3'];
	
	$schoolController = new AddSchoolController('school');
	$schoolController->addSchool($name, $city, $state, $email);
	//header('Location: http://campusloops.com/addSchool.php');
?>