<?php
	class ForumTopicController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function getForumTopics()
		{
			$sql = 'SELECT Forumid,forumname FROM ' . $this->tablename  . ' ORDER By forumname;';
			$result = $this->dbconn->prepare( $sql );
			$result->execute();
			$entry = $result->fetchall(PDO::FETCH_ASSOC);

			return($entry);
		}
	}
	
	$forums = new ForumTopicController('Forum_Topics');
	//$forum_topics = new array();
	$forum_topics = $forums->getForumTopics();
?>
		<div class="formSubjects">
			<ul class="formSubjects">
			<?php 
				//$index = 1;
				foreach($forum_topics as $value)
				{
					//print_r($value[Forumid]);
					echo("<li><a href = 'loops.php?id=$value[Forumid]'>$value[forumname]</a></li>");
						//$index++;
				}
			?>
			</ul>
		</div><!--end of formSubjects div-->