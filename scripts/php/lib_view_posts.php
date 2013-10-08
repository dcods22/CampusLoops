<!--Phil S -->
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
		
	}

	class UserController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'mars', $dbpass = 'mrCGdiIm', $url = 'lamp.it.marist.edu')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}

		function getName($userId){
			$sql = 'SELECT firstName,lastName,avatar FROM ' . $this->tablename  . ' WHERE userId=:userId;';
			$result = $this->dbconn->prepare( $sql );
			$result->bindValue(':userId', $userId);
			$result->execute();
			$entry = $result->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
	
	class ThreadNameController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'mars', $dbpass = 'mrCGdiIm', $url = 'lamp.it.marist.edu')
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
	}
?>