<?php //code by Dan Cody
	
	include('lib_check_login.php');
	include("lib_profile.php");

	class UpdateClass
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
		function getInfo($email)
		{
			// SQL Query gets the user's id via there email
			$sql = 'SELECT userId,firstName,lastName,avatar FROM ' . $this->tablename . ' WHERE email="' . $email . '"';
			$result = $this->dbconn->query( $sql );
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			
			// returns user info
			return($entry);
		}

		function updateDB($ID, $firstname, $lastname, $avatar, $birthday, $facebook, $twitter, $instagram, $linkedin, $tumblr)
		{
			$sql = 'UPDATE ' . $this->tablename . 
				   ' SET firstname = :firstName, lastname = :lastName, avatar = :avatar, birthDate = :birthday, facebook = :facebook, 
				   		twitter = :twitter, instagram = :instagram, linkedIn = :linkedin, tumblr = :tumblr WHERE userId="' . $ID . '"';

			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':firstName', $firstname );
			$stmt->bindValue( ':lastName', $lastname );
			$stmt->bindValue( ':avatar', $avatar );
			$stmt->bindValue( ':birthday', $birthday );
			$stmt->bindValue( ':facebook', $facebook );
			$stmt->bindValue( ':twitter', $twitter );
			$stmt->bindValue( ':instagram', $instagram );
			$stmt->bindValue( ':linkedin', $linkedin );
			$stmt->bindValue( ':tumblr', $tumblr );
			$stmt->execute();

		}
	}

	$ID = $_POST['userID'];

	$email = $_SESSION['email'];

	$info = new UpdateClass('User');

	$information = $info->getInfo($email);

	$firstname = null;
	$lastname = null;
	$avatar = null; 
	$birthday = null;
	$facebook = null;
	$twitter = null;
	$instagram = null;
	$linkedin = null;
	$tumblr = null;
	
	$newfacebook = $_POST['newfacebook'];
	$newfacebook = trim($newfacebook);
	
	$newfirstname = $_POST['newfirstname'];
	$newfirstname = trim($newfirstname);
	
	$newlastname = $_POST['newlastname'];
	$newlastname = trim($newlastname);
	
	$newavatar = $_POST['newavatar'];
	$newavatar = trim($newavatar);
	
	$newtwitter = $_POST['newtwitter'];
	$newtwitter = trim($newtwitter);
	
	$newinstagram = $_POST['newinstagram'];
	$newinstagram = trim($newinstagram);
	
	$newlinkedin = $_POST['newlinkedin'];
	$newlinkedin = trim($newlinkedin);
	
	$newtumblr = $_POST['newtumblr'];
	$newtumblr = trim($newtumblr);
	
	if(!empty($newfirstname)){
		$firstname = $newfirstname;
	}

	if(!empty($newlastname)){
		$lastname = $newlastname;
	}

	if(!empty($newavatar)){
		$avatar = $newavatar;
	}

	$month = $_POST['newmonth'];
	$day = $_POST['newday'];
	if($day < 10){$day = "0".$day;}
	$year = $_POST['newyear'];
	$birthday = $year . "-" . $month . "-" . $day ." 00:00:00";
	
	if(!empty($newfacebook)){
		$facebook = $newfacebook;
	}

	if(!empty($newtwitter)){
		$twitter = $newtwitter;
	}

	if(!empty($newinstagram)){
		$instagram = $newinstagram;
	}

	if(!empty($newlinkedin)){
		$linkedin = $newlinkedin;
	}

	if(!empty($newtumblr)){
		$tumblr = $newtumblr;
	}

	$info->updateDB($ID, $firstname, $lastname, $avatar, $birthday, $facebook, $twitter, $instagram, $linkedin, $tumblr);

	header("Location: http://campusloops.com/profile.php?id=$ID&edit=0");
	

?>