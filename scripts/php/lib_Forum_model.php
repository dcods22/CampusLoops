<?php //code by Philip Siconolfi

	class ForumController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function getForumTopicName($id){
			$sql = 'SELECT forumName FROM ' . $this->tablename . ' WHERE forumId=:id;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':id', $id);
			$statement->execute();
			$entry = $statement->fetch(PDO::FETCH_ASSOC);
			return($entry[forumName]);
		}
		
		function insertForumTopicName($forumName){
			$sql = 'INSERT INTO ' . $this->tablename . ' (forumName)' .
				   ' VALUES (:forumName);';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':forumName', $forumName);
			$statement->execute();
			}			
		function isforumNameAvailable($forumName)
		{
		$sql = 'SELECT * FROM ' . $this->tablename . ' WHERE forumName=:forumName;';
		$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':forumName', $forumName);
		$statement->execute();
		return($statement->fetch() == false);
		}
			
	}
	
?>