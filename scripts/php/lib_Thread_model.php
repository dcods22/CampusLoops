<?php
	class ThreadController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function getName($threadId){
			$sql = 'SELECT threadName FROM ' . $this->tablename  . ' WHERE threadId=:threadId;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':threadId', $threadId);
			$result->execute();
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function getLatestPostId($threadId){
			$sql = 'SELECT latestPostId FROM ' . $this->tablename  . ' WHERE threadId=:threadId;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':threadId', $threadId);
			$result->execute();
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			return($entry[latestPostId]);
		}
		
		function retrieveThreads($id){
			$sql = 'SELECT threadId,threadName,threadCreator,latestPostId FROM ' . $this->tablename  . ' WHERE Subforumid=:id ORDER By latestPostId desc;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':id', $id);
			$result->execute();
			$entry = $result->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function retrieveMultipleThreads($ids){
			$sql = 'SELECT threadId,threadName,threadCreator,latestPostId FROM ' . $this->tablename . ' WHERE ';
			for($i = 0; $i < (count($ids) - 1); $i++)
			{
				$sql .= 'threadId=:threadId' . $i . ' OR ';
			}
			$sql .= 'threadId=:threadId' . (count($ids) - 1) . ' ORDER BY latestPostId desc;';
			
			$statement = $this->dbconn->prepare( $sql );
			
			for($i = 0; $i < count($ids); $i++)
			{
				$x = ':threadId' . $i;
				$id = $ids[$i];
				$statement->bindValue($x, $id);
			}
			
			$statement->execute();
			
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		
		function addPost($postId, $threadId){
			$sql = 'UPDATE ' . $this->tablename .' SET latestPostId=:postId WHERE threadId=:threadId;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':postId', $postId);
			$statement->bindValue(':threadId', $threadId);
			$statement->execute();
		}
		
		function addThread($subforumId, $threadName, $userId){
			// default postId and postCount
			$postId = 0;
			$postCount = 1;
			
			$sql = 'INSERT INTO ' . $this->tablename . ' (subforumId, threadName, threadCreator, latestPostId, postCount)' .
				   ' VALUES (:subforumId, :threadName, :threadCreator, :latestPostId, :postCount);';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':subforumId', $subforumId);
			$statement->bindValue(':threadName', $threadName);
			$statement->bindValue(':threadCreator', $userId);
			$statement->bindValue(':latestPostId', $postId);
			$statement->bindValue(':postCount', $postCount);
			$statement->execute();
		}
		
		function getThreadId($subforumId, $threadName, $userId, $postId, $postCount){
			$sql = 'SELECT threadId FROM ' . $this->tablename . ' WHERE subforumId=:subforumId AND threadName=:threadName AND ' . 
				   'threadCreator=:threadCreator AND latestPostId=:latestPostId AND postCount=:postCount;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':subforumId', $subforumId);
			$statement->bindValue(':threadName', $threadName);
			$statement->bindValue(':threadCreator', $userId);
			$statement->bindValue(':latestPostId', $postId);
			$statement->bindValue(':postCount', $postCount);
			$statement->execute();
			$entry = $statement->fetch(PDO::FETCH_ASSOC);
			return($entry[threadId]);
		}
		
		function searchThreads($search){
			$sql = 'SELECT threadId,threadName,threadCreator,latestPostId FROM ' . $this->tablename  . ' WHERE threadName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function retrieveHomeThreads(){
			$sql = 'SELECT threadId,threadName,threadCreator,latestPostId FROM ' . $this->tablename  . ' ORDER By latestPostId desc LIMIT 0,10;';
			$result = $this->dbconn->prepare( $sql );
			$result->execute();
			$entry = $result->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
?>
