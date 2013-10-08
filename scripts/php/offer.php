<?php

	class Offer
	{
		private $dbconn;
		private $table;

		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		function addOffer($sellerID, $buyerID, $bookID, $price)
		{
			$sql = 'INSERT INTO bookOffer (sellerID, buyerID, bookID, price) VALUES ( :sellerID, :buyerID, :bookID, :price);';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':sellerID', $sellerID );
			$stmt->bindValue( ':buyerID', $buyerID );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->bindValue( ':price', $price );
			$stmt->execute();			
		}
		
		function getEmail($userId)
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
		
		function getBookName($bookID)
		{
			//sql SELECT statement
			$sql = 'SELECT bookTitle FROM books WHERE bookID=:bookID;';
			//echo " ID gotten";
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[bookTitle]);
		}
		
	}
	
	$userID = $_POST['userID'];
	$copyID = $_POST['copyID'];	
	$bookID = $_POST['bookID'];
	$sellerID = $_POST['sellerID'];
	$price = $_POST['offerPrice'];
	$offerMessage = $_POST['offerMessage'];
	
	if(!empty($price)):
		
		$offerController = new Offer('bookOffer');
		$offerController->addOffer($sellerID, $userID, $bookID, $price);
		$email = $offerController->getEmail($sellerID);
		$bookName = $offerController->getBookName($bookID);
		$subject = 'Book offer for ' . $bookName;
		$headers = "From: noreply@campusloops.com \r\n";	
		$message = 'You have received an offer for ' . $bookName . ' for $' . $price . '. 
		Attached to the offer was, ' . $offerMessage . '	
		If you would like to make an decline, counter offer or accept this offer please click the link below. 
		http://campusloops.com/offer.php?copyID=' . $copyID . '&sellerID=' . $sellerID . '&bookID=' . $bookID;
		
		mail($email, $subject, $message, $headers);		
		header('Location: http://campusloops.com/offer.php?copyID=' . $copyID . '&sellerID=' . $sellerID . '&bookID=' . $bookID);	
	else:
	
		header('Location: http://campusloops.com/bookCopy.php?id=' . $sellerID);
	
	endif;
?>