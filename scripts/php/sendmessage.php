<?php //Code by Dan Cody

	include('lib_check_login.php');
	include("lib_profile.php");
	include('lib_User_model.php');
	include('lib_getUser.php');
	include("lib/template/header.php");
	
	$ID = $currentUser[userId];
	$currEmail = $_SESSION['email'];

	class SendMessageController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function getUserID($first, $last)
		{
			//sql SELECT statement
			$sql = 'SELECT userId FROM User WHERE firstName=:first AND lastName=:last;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':first', $first );
			$stmt->bindValue( ':last', $last );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[userId]);
		}		
		
		function getInboxID($senderID, $receiverID)
		{
			//sql SELECT statement
			$sql = 'SELECT inboxID FROM inbox WHERE senderID=:senderID AND receiverID=:receiverID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':senderID', $senderID );
			$stmt->bindValue( ':receiverID', $receiverID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[inboxID]);			
		}
		
		function getSentID($senderID, $receiverID)
		{
			//sql SELECT statement
			$sql = 'SELECT sentID FROM sent WHERE senderID=:senderID AND receiverID=:receiverID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':senderID', $senderID );
			$stmt->bindValue( ':receiverID', $receiverID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[sentID]);			
		}
		
		function checkInboxID($senderID, $receiverID)
		{
			$sql = "SELECT count(*) FROM inbox WHERE senderID='" . $senderID . "' and receiverID='" . $receiverID . "';";

			$result = $this->dbconn->query( $sql );
			$row = $result->fetch(PDO::FETCH_NUM);
			
			if($row[0] > 0){ 
				return 0;
			}
			else {
				return 1;
			}
		}
		
		function checkSentID($senderID, $receiverID)
		{
			$sql = "SELECT count(*) FROM sent WHERE senderID='" . $senderID . "' and receiverID='" . $receiverID . "';";

			$result = $this->dbconn->query( $sql );
			$row = $result->fetch(PDO::FETCH_NUM);
			
			if($row[0] > 0){ 
				return 0;
			}
			else {
				return 1;
			}
		}
		
		function addMessage($senderID, $receiverID, $messageText, $inboxID, $subject, $sentID)
		{
			// build INSERT query string
			$sql = 'INSERT INTO ' . $this->tablename . ' (senderID, receiverID, messageText, inboxID, subject, messageTime, sentID) VALUES ( :senderID , :receiverID, :messageText , :inboxID, :subject, :messageTime, :sentID );';

			$time = date("Y-m-d H:i:s");
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':senderID', $senderID );
			$stmt->bindValue( ':receiverID', $receiverID );
			$stmt->bindValue( ':messageText', $messageText ); 
			$stmt->bindValue( ':inboxID', $inboxID );
			$stmt->bindValue( ':subject', $subject );
			$stmt->bindValue( ':sentID', $sentID );
			$stmt->bindValue( ':messageTime', $time );
			$stmt->execute();
		}
		
		function addSent($senderID, $receiverID, $subject)
		{
			$sql = "SELECT count(*) FROM sent WHERE senderID='" . $senderID . "' and receiverID='" . $receiverID . "';";

			$result = $this->dbconn->query( $sql );
			$row = $result->fetch(PDO::FETCH_NUM);
		
			if( $row[0] == 0 )
			 {
				// build INSERT query string
				$sql = 'INSERT INTO sent (senderID, receiverID, subject, latestTime) VALUES ( :senderID , :receiverID, :subject, :latestTime );';
				
				$time = date("Y-m-d H:i:s");
				// submit database query
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':senderID', $senderID );
				$stmt->bindValue( ':receiverID', $receiverID );
				$stmt->bindValue( ':subject', $subject );
				$stmt->bindValue( ':latestTime', $time );			
				$stmt->execute();
			}
			else
			{
				// build INSERT query string
				$sql = 'UPDATE sent SET latestTime=:latestTime, subject=:subject WHERE senderID=:senderID AND receiverID=:receiverID;';
				
				$time = date("Y-m-d H:i:s");
				// submit database query
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':latestTime', $time );
				$stmt->bindValue( ':senderID', $senderID );
				$stmt->bindValue( ':subject', $subject );
				$stmt->bindValue( ':receiverID', $receiverID );			
				$stmt->execute();
			}
		}
		
		function addInbox($senderID, $receiverID, $subject)
		{
		
			$sql = "SELECT count(*) FROM inbox WHERE senderID='" . $senderID . "' and receiverID='" . $receiverID . "';";

			$result = $this->dbconn->query( $sql );
			$row = $result->fetch(PDO::FETCH_NUM);
			
			if( $row[0] == 0 )
			{
				// build INSERT query string
				$sql = 'INSERT INTO inbox (senderID, receiverID, subject, latestTime) VALUES ( :senderID , :receiverID, :subject, :latestTime );';
				
				$time = date("Y-m-d H:i:s");
				// submit database query
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':senderID', $senderID );
				$stmt->bindValue( ':receiverID', $receiverID );
				$stmt->bindValue( ':subject', $subject );
				$stmt->bindValue( ':latestTime', $time );			
				$stmt->execute();
			}
			else
			{
				// build INSERT query string
				$sql = 'UPDATE inbox SET latestTime=:latestTime, subject=:subject WHERE senderID=:senderID AND receiverID=:receiverID;';
				
				$time = date("Y-m-d H:i:s");
				// submit database query
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':latestTime', $time );
				$stmt->bindValue( ':senderID', $senderID );
				$stmt->bindValue( ':subject', $subject );
				$stmt->bindValue( ':receiverID', $receiverID );			
				$stmt->execute();
			}
		}
	}

	if(isset($_POST['receiver'])){
		$receiver = $_POST['receiver'];
	}

	$subject = $_POST['subject'];
	if($subject==""){
		$subject="No Subject";
	}
	
	if(isset($_POST['bodymessage'])){
		$messageText = $_POST['bodymessage'];
	}
	
	$senderID = $ID;
	
	$messageController = new SendMessageController('messages');
	
	list($first,$last) = explode(' ' , $receiver);
	$receiverID = $messageController->getUserID($first, $last);
	$messageController->addInbox($senderID, $receiverID, $subject);
	$inboxID = $messageController->getInboxID($senderID, $receiverID);
	$messageController->addSent($senderID,$receiverID, $subject);
	$sentID = $messageController->getSentID($senderID, $receiverID);
	$messageController->addMessage($senderID, $receiverID, $messageText, $inboxID, $subject, $sentID);
	header("Location: http://campusloops.com/messages.php?m=0");

?>