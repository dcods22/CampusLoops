<?php

	class ChatController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
	
		function getChats($userID)
		{
			//sql SELECT statement
			$sql = 'SELECT * FROM chat WHERE openID=:userId;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userID );
			$stmt->execute();
			$entry = $stmt->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	
	}
	
	$chatController = new ChatController('chat');
	$chats = $chatController->getChats($currentUser[userId]);
	foreach($chats as $chat):
	?>
		<div class='chatFloat'>
			
		</div>	
	<?
	endforeach;
?>