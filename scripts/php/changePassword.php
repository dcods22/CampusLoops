<?php
	
	class PasswordController
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
		
		function updatePassword($password, $userId)
		{
			$sql = 'UPDATE User SET password=:password WHERE userId=:userId;';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userId );
			$stmt->bindValue( ':password', $password );
			$stmt->execute();	
		}
		
		function changeCheck($userID)
		{

			$sql = "SELECT count(*) FROM passChange WHERE userID=" . $userID . ";";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			if($count[0] == 0)
			{
				return false;
			}
			else
			{
				
				$sql = 'DELETE FROM passChange WHERE userID=:userID;';
				$statement = $this->dbconn->prepare( $sql );
				$statement->bindValue(':userID', $userID);
				$statement->execute();
				
				return true;
			}	
		
		}
		
	}
	
	$userID = $_POST['userID'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	
	if(empty($password1) || empty($password2))
	{
		header('Location: http://campusloops.com/changed.php?id=' . $userID . '&error=3');	
	}
	
	$passwordController = new PasswordController('User');
	
	if($passwordController->changeCheck($userID))
	{
		if($passwordController->passwordCheck($password1, $password2))
		{
			if($passwordController->passwordStrength($password1))
			{						   
				$password1 = crypt($password1, $passwordController->make_salt_key());
				$passwordController->updatePassword($password1, $userID);
				header('Location: http://campusloops.com/changed.php?id=' . $userID . '&success=1');				
			}
			else
			{
				header('Location: http://campusloops.com/changed.php?id=' . $userID . '&error=1');							
			}
		}
		else 
		{
			header('Location: http://campusloops.com/changed.php?id=' . $userID . '&error=2');
		}
	}
	else
	{
		header('Location: http://campusloops.com');
	}
?>