<?php //Code by Dan Cody
	
	class Register
	{
		private $dbconn;
		private $table;

		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function passwordCheck($password1,$password2)
		{
			if($password1 == $password2){
				return true;
			}else{
				return false;
			}
		}
		
		function make_salt_key()
		{
			$str = '/.0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$num = strlen($str) - 1;
			$salt = '$6$rounds=5000$';
			for($i = 0; $i < 21; $i++){
				$salt .= $str[mt_rand(0, $num)];
			}
			$salt .= '$';
			return($salt);
		}
		
		function passwordStrength($password)
		{
			if(strlen($password) < 5){
				return false;
			}
			else if(!preg_match("#[0-9]+#", $password)){
				return false;
			}
			else
			{
				return true;
			}
		}
	
		function isUnameAvailable( $username )
	   {
	      // build query string
	      $sql = 'SELECT email FROM ' . $this->tablename . ' WHERE email=:email';

	      // submit database query
	      $result = $this->dbconn->prepare( $sql );
		  $result->bindValue(':email', $username);
	      return ( $result->fetch() == false );
	   }

		function addUser($firstname, $lastname, $email, $password)
		{
			
			// build INSERT query string
			$sql = 'INSERT INTO ' . $this->tablename . ' (firstname, lastname, email, password, avatar) 
					VALUES ( :firstName , :lastName, :email , :password, :avatar )';

			$avatar = "http://campusloops.com/f.jpg";
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':firstName', $firstname );
			$stmt->bindValue( ':lastName', $lastname );
			$stmt->bindValue( ':email', $email ); 
			$stmt->bindValue( ':password', $password );
			$stmt->bindValue( ':avatar', $avatar );
			$stmt->execute();
		}

		function emailCheck($email)
		{

			$atpos = strpos($email,'@');
			$perpos = strpos($email, '.');
			$edu = strpos($email, '.edu');
			//$marist = strpos($email, '@marist.edu');

			if (empty($email)) 
			{
	            return false;
	        } 
	        else if($atpos === false) 
	        {
	           return false;
	        } 
	        else if($perpos === false) 
	        {
	           return false;
	        }
	        else if($edu === false)
	        {
	        	return false;
	        }
	        else
	        {
	        	return true;
	        }
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

	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email1'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];

		$email = trim($email);
		
		$subject = 'Campus Loops Validation';
		$headers = "From: noreply@campusloops.com \r\n";
		
		$register = new Register('User');

		if(!empty($firstname))
		{
			if(!empty($lastname))
			{
				if($register->emailCheck($email))
				{
					if($register->isUnameAvailable($email))
					{
						if($register->passwordCheck($password1, $password2))
						{
							if($register->passwordStrength($password1))
							{						   
								/*$password1 = crypt($password1, $register->make_salt_key());
								$register->addUser($firstname,$lastname,$email,$password1);
								$newID = $register->getUserID($email);
								$emailMessage = 'Click on the link to validate your Campus Loops account.  http://campusloops.com/validation.php?id=' . $newID;
								mail($email, $subject, $emailMessage, $headers);
								header('Location: http://campusloops.com/validate.php?id=' . $newID);*/
								
							}
							else
							{
								header('Location: http://campusloops.com/register.php?error=7');							
							}
						}
						else 
						{
							header('Location: http://campusloops.com/register.php?error=4');
						}
					}
					else
					{
						header('Location: http://campusloops.com/register.php?error=5');
					}
				}
				else 
				{
					header('Location: http://campusloops.com/register.php?error=3');
				}			
			}
			else
			{
				header('Location: http://campusloops.com/register.php?error=2');
			}
		}
	  	else
	  	{

	  		header('Location: http://campusloops.com/register.php?error=1');
	  
	 	}
	}
	else
	{
		header('Location: http://campusloops.com/register?error=6');
	}	

?>