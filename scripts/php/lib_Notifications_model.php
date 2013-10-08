<?php // code by Phil Picinic
	
	class NotificationController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
	
		function addToNotification($userId, $threadId, $postId){
			$sql = 'INSERT INTO ' . $this->tablename . ' (userId, threadId, postId) VALUES (:userId, :threadId, :postId);';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':userId', $userId);
			$statement->bindValue(':threadId', $threadId);
			$statement->bindValue(':postId', $postId);
			$statement->execute();
		}
		
		function hasUserPosted($userId, $threadId){
			$sql = 'SELECT postId FROM ' . $this->tablename . ' WHERE userId=:userId AND threadId=:threadId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':userId', $userId);
			$statement->bindValue(':threadId', $threadId);
			$statement->execute();
			$entry = ($statement->fetch() == false);
			return(!$entry);
		}
		
		function getNotifId($userId, $threadId){
			$sql = 'SELECT notifId FROM ' . $this->tablename . ' WHERE userId=:userId AND threadId=:threadId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':userId', $userId);
			$statement->bindValue(':threadId', $threadId);
			$statement->execute();
			$entry = $statement->fetch(PDO::FETCH_ASSOC);
			return($entry[notifId]);
		}
		
		function updateNotification($notifId, $postId){
			$sql = 'UPDATE ' . $this->tablename . ' SET postId=:postId WHERE notifId=:notifId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':postId', $postId);
			$statement->bindValue(':notifId', $notifId);
			$statement->execute();
		}
		
		function getNotifications($userId){
			$sql = 'SELECT * FROM ' . $this->tablename . ' WHERE userId=:userId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':userId', $userId);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function getPostId($notifId){
			$sql = 'SELECT postId FROM ' . $this->tablename . ' WHERE notifId=:notifId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':notifId', $notifId);
			$statement->execute();
			$entry = $statement->fetch(PDO::FETCH_ASSOC);
			return($entry[postId]);
		}
		
		function getNotificationCount($userID)
		{
			$sql = 'SELECT count(*) FROM ' .$this->tablename . ' WHERE userId=' . $userID . ';';
			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			return($count[0]);
		}
		
	}
?>