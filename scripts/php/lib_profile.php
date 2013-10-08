<?php //code by Phil Picinic

	class ProfileController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		// grabs all the users information sans password from the database
		function fetchUserData($id)
		{
			$sql = 'SELECT firstName,lastName,email,avatar,facebook,twitter,tumblr,instagram,linkedIn,birthDate FROM ' 
					. $this->tablename . ' WHERE userId="' . $id . '"';
			$result = $this->dbconn->query( $sql );
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
	
	$id = $_GET['id'];
	$userFetcher = new ProfileController('User');
	$userInfo = $userFetcher->fetchUserData($id);
?>