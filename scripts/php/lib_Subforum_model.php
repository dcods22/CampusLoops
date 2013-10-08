<?php
	//code by Phil Picinic
	class SubForumController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function grabSubforums($forum_topic){
			$sql = 'SELECT subforumId, subforumName FROM ' . $this->tablename  . ' WHERE Forumid=:forum;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':forum', $forum_topic);
			$result->execute();
			$entry = $result->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function getSubforumName($id){
			$sql = 'SELECT subforumName FROM ' . $this->tablename  . ' WHERE subforumId=:id;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':id', $id);
			$result->execute();
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			return($entry[subforumName]);
		}
		
		function addSubforum($forumId, $subforumName){
			$sql = 'INSERT INTO ' . $this->tablename . ' (forumId, subforumName) VALUES (:forumId, :subforumName);';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':forumId', $forumId);
			$statement->bindValue(':subforumName', $subforumName);
			$statement->execute();
		}
		
		function getSubforumId($subforumName, $forumId){
			$sql = 'SELECT subforumId FROM ' . $this->tablename . ' WHERE subforumName=:subforumName AND forumId=:forumId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':subforumName', $subforumName);
			$statement->bindValue(':forumId', $forumId);
			$statement->execute();
			$entry = $statement->fetch(PDO::FETCH_ASSOC);
			return($entry[subforumId]);
		}
		
		function isSubforumNameAvailable($subforumName, $forumId){
			$sql = 'SELECT * FROM ' . $this->tablename . ' WHERE subforumName=:subforumName AND forumId=:forumId;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':subforumName', $subforumName);
			$statement->bindValue(':forumId', $forumId);
			$statement->execute();
			return($statement->fetch() == false);
		}
	}
?>