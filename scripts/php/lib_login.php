<?php //code by Phil Picinic

	// Login class connects to the database and has a function to validate login
	class LoginController
	{
		private $dbconn;
		private $tablename;
		
		// constructor takes in a tablename, and defaults to our database
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		// checks login passwords should be sent unhashed.
		function validate_login($username, $password)
		{
			// SQL Query gets the user's password via there email
			$sql = 'SELECT email,password FROM ' . $this->tablename . ' WHERE email=:email';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':email', $username);
			$result->execute();
			$entry = $result->fetch();
			
			// if no entry is found login fails
			if ($entry == false){
				return false;
			}
			
			// checks the password against the password hash
			return(crypt($password, $entry[password]) == $entry[password]);
		}
		
		function checkActive($email)
		{
			$sql = 'SELECT activated FROM ' . $this->tablename . ' WHERE email=:email';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':email', $email);
			$result->execute();
			$entry = $result->fetch();
			
			return $entry;
		
		}
		
		function getSchoolID($email)
		{
			//sql SELECT statement
			$sql = 'SELECT schoolID FROM User WHERE email=:email;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':email', $email );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[schoolID]);
		}
	}
	
	// if this page gets a POST request this code is run to log the user in
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		// gets email and password from POST
		$email = $_POST['loginEmail'];
		$passwd = $_POST['loginPassword'];
		
		
		// creates a LoginController object to use
		$login = new LoginController('User');
		// checks if the login is valid
		$schoolID = $login->getSchoolID($email);
		if($login->checkActive($email))
		{
			if ($login->validate_login($email, $passwd))
			{	
				
				// starts the user's session
				session_save_path("/home/users/web/b2942/ipg.campusloops/sessions");
				session_start();
				$_SESSION['loggedin'] = "yes";
				$_SESSION['email'] = $email;
				$_SESSION['schoolID'] = $schoolID;
				
				// if the user checked the remember me, this adds a cookie to save the user's session id 
				if(isset($_POST['remember'])){
					$timeLength = 86400 * 365;
					setcookie('remember_me', session_id(), time()+$timeLength, '/', 'campusloops.com');
				}
				//print_r($_SESSION);
				// redirect to the main home page after successful login
				header('Location: http://campusloops.com/home.php');
				
			}
			else
			{
				// redirect for failed login
				header('Location: http://campusloops.com/login.php?error=1');
			}
		}
		else
		{
			// redirect for failed login
			header('Location: http://campusloops.com/login.php?error=1');
		}
	}
	else
	{
		// redirect in case an error occurs
		header('Location: http://campusloops.com/login.php?error=2');
	}
?>	