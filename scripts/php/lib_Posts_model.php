<?php
	class PostsController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function retrievePosts($id){
			$sql = 'SELECT postId,userId,postDate,editDate,postBlock FROM ' . $this->tablename  . ' WHERE threadId=:id ORDER BY postId;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':id', $id);
			$result->execute();
			$entry = $result->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function addPost($userId, $threadId, $postBlock){
			//get current time as timestamp
			//$date = new DateTime('now');
			//$timestamp = $date->getTimestamp();
			$myTime = date("Y-m-d H:i:s");
			
			// build INSERT query string
			$sql = 'INSERT INTO ' . $this->tablename . ' (userId, threadId, postDate, postBlock) VALUES ( :userId , :threadId, :postDate, :postBlock );';

			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userId );
			$stmt->bindValue( ':threadId', $threadId );
			$stmt->bindValue( ':postDate', $myTime ); 
			$stmt->bindValue( ':postBlock', $postBlock );
			$stmt->execute();
		}
		
		function editPost($postBlock, $postId){
			$time = date("Y-m-d H:i:s");
			$sql = 'UPDATE ' . $this->tablename . ' SET editDate=:time, postBlock=:post WHERE postId=:id;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':time', $time);
			$statement->bindValue(':post', $postBlock);
			$statement->bindValue(':id', $postId);
			$statement->execute();
		}
		
		function getLatestPostId($threadId){
			$sql = 'SELECT postId FROM ' . $this->tablename  . ' WHERE threadId=:threadId ORDER By postId desc;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':threadId', $threadId);
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			return($result[postId]);
		}
		
		function deletePost($postId) {
			$sql = 'DELETE FROM ' . $this->tablename . ' WHERE postId =:postId;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':postId', $postId);
			$statement->execute();	
		}
		
		function searchPosts($search){
			$sql = 'SELECT DISTINCT threadId FROM ' . $this->tablename . ' WHERE postBlock LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
?>