<?php //Code by Rick Gutierrez 

include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");

	class deleteSent
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com') 
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function deleteSentMsg($sentID)	{
			$sql = 'DELETE FROM ' .$this->tablename . ' WHERE sentID =:sentID;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':sentID', $sentID);
			$statement->execute();
		}
	   
		function deleteSentMessage($sentID) {
			$sql = 'DELETE FROM messages WHERE sentID =:sentID;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':sentID', $sentID);
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
		$deleteController = new deleteSent('sent');
		//$sentID = $delete;
		$sentID = $_POST['delete'];
		$deleteController->deleteSentMsg($sentID);
		header('Location: http://campusloops.com/messages.php?m=1');
	//}
?>
