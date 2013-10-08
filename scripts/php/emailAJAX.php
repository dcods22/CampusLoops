<?php

	class EmailController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function searchUser($search)
		{
			$sql = 'SELECT * FROM ' . $this->tablename  . ' WHERE lastName LIKE :search OR firstName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchFirstLast($search1, $search2)
		{
			$sql = 'SELECT * FROM ' . $this->tablename  . ' WHERE lastName LIKE :search1 AND firstName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search1);
			$statement->bindValue(':search1', $search2);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
	
	$search1 = $_POST['receiver'];
	if(!empty($search1))
	{
		$search = '%' . $search1 . '%'; 
		$emailController = new EmailController('User');
		$user = $emailController->searchUser($search);
		//$userFL = $emailController->searchFirstLast($search, $search);
		echo "<ul class='emailAjax'>";
		foreach($user as $users):
			echo '<li><a href="#" onclick="addText(\'' . $users[firstName] . ' ' . $users[lastName] . '\')">' . $users[firstName] . ' ' . $users[lastName] . "</a></li>";
		endforeach;
		echo "</ul>";
	}
?>
