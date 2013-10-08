<?php
	class MessageController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function getInbox($ID)
		{
			$sql = "SELECT senderID,subject,inboxID, latestTime FROM inbox WHERE receiverID = '" . $ID . "' ORDER BY latestTime DESC;";
			$result = $this->dbconn->query( $sql );
			return($result);
		}

		function getSent($ID)
		{
			$sql = "SELECT receiverID,subject,sentID, latestTime FROM sent WHERE senderID = '" . $ID . "' ORDER BY latestTime DESC;";
			$result = $this->dbconn->query( $sql );
			return($result);
		}
		
		function getUserEmail($userId)
		{
			//sql SELECT statement
			$sql = 'SELECT email FROM User WHERE userId=:userId;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userId );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[email]);
		}
		
		function getUserName($userId)
		{
			//sql SELECT statement
			$sql = 'SELECT firstName, lastName FROM User WHERE userId=:userId;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userId );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			$firstname = $entry[firstName];
			$lastname = $entry[lastName];
			$name = $firstname . " " . $lastname;
			return($name);
		}
		
		function getMessageInfo($inboxID)
		{
			//sql SELECT statement
			$sql = "SELECT senderID, receiverID, inboxID FROM " . $this->tablename  . " WHERE inboxID='" . $inboxID . "'";
			// submit database query
			$result = $this->dbconn->query( $sql );
			return($result);
		}
		
		function messageCount($senderID, $receiverID)
		{
			$sql = "SELECT count(*) FROM " . $this->tablename  . " WHERE ((senderID='" . $senderID . "' AND receiverID='" . $receiverID ."') OR (senderID='" . $receiverID . "' and receiverID='" . $senderID . "'));";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			return($count[0]);
		}
		
		function getMessages($receiverID, $senderID)
		{
			//sql SELECT statement
			$sql = "SELECT * FROM " . $this->tablename  . " WHERE (senderID='" . $senderID . "' AND receiverID='" . $receiverID ."') OR (senderID='" . $receiverID . "' and receiverID='" . $senderID . "') ORDER BY messageTime ASC;";
			// submit database query
			$result = $this->dbconn->query( $sql );
			return($result);
		}
		
		function getRecIDInbox($inboxID)
		{
			//sql SELECT statement
			$sql = 'SELECT receiverID FROM inbox WHERE inboxID=:inboxID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':inboxID', $inboxID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[receiverID]);
		}
		
		function getSendIDInbox($inboxID)
		{
			//sql SELECT statement
			$sql = 'SELECT senderID FROM inbox WHERE inboxID=:inboxID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':inboxID', $inboxID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[senderID]);
		}
		
		function getRecIDSent($sentID)
		{
			//sql SELECT statement
			$sql = 'SELECT receiverID FROM sent WHERE sentID=:sentID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':sentID', $sentID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[receiverID]);
		}
		
		function getSendIDSent($sentID)
		{
			//sql SELECT statement
			$sql = 'SELECT senderID FROM sent WHERE sentID=:sentID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':sentID', $sentID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[senderID]);
		}
		
		function getUserAvatar($userId)
		{
			//sql SELECT statement
			$sql = 'SELECT avatar FROM User WHERE userId=:userId;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userId );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[avatar]);
			
		}
		
	}

	$email = $_SESSION['email'];
	$ID = $currentUser[userId];

?>