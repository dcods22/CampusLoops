<?php //Code by Rick Gutierrez 

include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");

	class deleteMessage
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com') 
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
       function deleteInboxMsg($inboxID)	{
	       $sql = 'DELETE FROM ' .$this->tablename . ' WHERE inboxID =:inboxID;';
		   $statement = $this->dbconn->prepare( $sql );
		   $statement->bindValue(':inboxID', $inboxID);
		   $statement->execute();
	   }
	   
	   function deleteSentMessage($inboxID) {
	     $sql = 'DELETE FROM messages WHERE inboxID =:inboxID;';
		 $statement = $this->dbconn->prepare( $sql );
		 $statement->bindValue(':inboxID', $inboxID);
		 $statement->execute();
	   }
	}
	
	//$i=0;
	//$messageArray = new array();
	
	//while (isset($_POST['delete'. i])){
		//add value in delete i to the array
		//$messageArray = 
		//$i++;
	//}
	
	//foreach($messageArray as $delete){
		$deleteController = new deleteMessage('inbox');
		//$inboxID = $delete;
		$inboxID = $_POST['delete'];
		$deleteController->deleteInboxMsg($inboxID);
		header('Location:http://campusloops.com/messages.php?m=0');
	//}
?>



