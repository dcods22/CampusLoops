<?php 
class ForumController
	{
		private $dbconn;
		private $tablename;
		

	function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function insertForumTopicName($id){
			sql = 'INSERT INTO ' . $this->tablename . ' (topicId)' .
				   ' VALUES (:forumName);';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':id', $id);
			$statement->execute();
			
		}
		
?>