<?php

	class BookController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
		
		/* search for books by ISBN */		
		function searchBookISBN($search)
		{
			$search = '%' . $search . '%';
			$sql = 'SELECT bookID,ISBN,author,bookTitle,edition,picture FROM ' . $this->tablename  . ' WHERE ISBN LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* search for books by Author */
		function searchBookAuthor($search)
		{
			$search = '%' . $search . '%';
			$sql = 'SELECT bookID,ISBN,author,bookTitle,edition,picture FROM ' . $this->tablename  . ' WHERE author LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* search for books by Title */
		function searchBookTitle($search)
		{
			$search = '%' . $search . '%';
			$sql = 'SELECT bookID,ISBN,author,bookTitle,edition,picture FROM ' . $this->tablename  . ' WHERE bookTitle LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* search for books by Subject */
		function searchBookSubject($search)
		{
			//$search = '%' . $search . '%';
			$sql = 'SELECT bookID FROM bookCopy WHERE subject=:search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* get first and last names by userID */
		function getSenderName($ID)
		{
			//sql SELECT statement
			$sql = 'SELECT firstName, lastName FROM User WHERE userId=:ID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':ID', $ID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			$name = $entry[firstName] . ' ' . $entry[lastName];
			return($name);
		}
		
		/* get bookID by ISBN */
		function getBookID($ISBN)
		{
			//sql SELECT statement
			$sql = 'SELECT bookID FROM books WHERE ISBN=:ISBN;';
			//echo " ID gotten";
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':ISBN', $ISBN );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[bookID]);
		}
		
		/* does a book exist with that ISBN */
		function bookExists($ISBN)
		{
			$sql = "SELECT count(*) FROM books WHERE ISBN=" . $ISBN . ";";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			if($count[0] == 0){
				return false;
			}else{
				return true;
			}
		}
		
		/* add a book to the book table if it doesnt exist */
		function addBook($bookTitle, $author, $ISBN, $picture, $edition)
		{	
			$sql = "SELECT count(*) FROM books WHERE ISBN=" . $ISBN . ";";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			//echo "count: " . $count[0];
			if($count[0] == 0)
			{
				// build INSERT query string
				$sql = 'INSERT INTO books (bookTitle, author, ISBN, picture, edition, numCopy) VALUES ( :bookTitle, :author , :ISBN, :picture, :edition, :numCopy);';
				
				// submit database query
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':bookTitle', $bookTitle );
				$stmt->bindValue( ':author', $author );
				$stmt->bindValue( ':ISBN', $ISBN );
				$stmt->bindValue( ':picture', $picture );
				$stmt->bindValue( ':edition', $edition );
				$stmt->bindValue( ':numCopy', 1);
				$stmt->execute();
				
				//echo " inserted into book";
			}
			else 
			{
				$sql = 'SELECT bookID FROM books WHERE ISBN=:ISBN;';

				// submit database query
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':ISBN', $ISBN );
				$stmt->execute();
				$entry = $stmt->fetch(PDO::FETCH_ASSOC);
				$bookID = $entry[bookID];
				
				$sql = 'SELECT count(*) FROM bookCopy WHERE bookID=' . $bookID . ';';
				// submit database query
				$result = $this->dbconn->query( $sql );
				$amount = $result->fetch(PDO::FETCH_NUM);
				
				$numCopy = $amount[0] + 1;
				//echo $numCopy;
			
			    $sql = 'UPDATE books SET numCopy = :numCopy WHERE ISBN=:ISBN;'; 
				
				$stmt = $this->dbconn->prepare( $sql );
				$stmt->bindValue( ':numCopy', $numCopy );
				$stmt->bindValue( ':ISBN', $ISBN );
				$stmt->execute(); 
			}
		}
		
		/*add a book copy */
		function addBookCopy($bookID, $sellerID, $price, $condition, $datePosted, $description, $subject)
		{			
			// build INSERT query string
			$sql = 'INSERT INTO `bookCopy` ( `bookID` , `sellerID` , `Condition` , `price` , `datePosted` , `description`, `subject` ) VALUES ( :bookID, :sellerID, :condition, :price, :datePosted, :description, :subject);';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->bindValue( ':sellerID', $sellerID );
			$stmt->bindValue( ':price', $price );
			$stmt->bindValue( ':condition', $condition );	
			$stmt->bindValue( ':datePosted', $datePosted);
			$stmt->bindValue( ':description', $description);	
			$stmt->bindValue( ':subject', $subject);
			$stmt->execute();
			//echo 'bookid: ' . $bookID . ' sellerid: ' . $sellerID . ' price:' . $price . ' condition:' . $condition . ' date:' . $datePosted . ' desc:' . $description;
		}

		/* get bok info based on bookID */		
		function getBookInfo($bookID)
		{
			//sql SELECT statement
			$sql = 'SELECT author, bookTitle, ISBN, edition, picture FROM books WHERE bookID=:bookID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* get all books from bookcopy based on bookID */
		function getAllBooks($bookID)
		{
			//sql SELECT statement
			$sql = 'SELECT * FROM bookCopy WHERE bookID=:bookID;';
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->execute();
			$entry = $stmt->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* count amount for sale by that sellers userID */
		function bookSaleCountProfile($sellerID)
		{
			$sql = "SELECT count(*) FROM bookCopy WHERE sellerID=" . $sellerID . ";";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			return($count[0]);
		}
		
		/* count amount of books for sale by bookID */
		function bookSaleCountID($bookID)
		{
			$sql = "SELECT count(*) FROM bookCopy WHERE bookID=" . $bookID . ";";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			return($count[0]);
		}
		
		/* get copyID from bookCopy based on bookID */
		function getCopyID($bookID)
		{
			$sql = 'SELECT copyID FROM bookCopy WHERE bookID=:bookID;';
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->execute();
			$copyReturn = $stmt->fetch(PDO::FETCH_ASSOC);
			return($copyReturn[copyID]);	
		}
		
		/* get all info from bookCopy based on userID */
		function getBooksSold($sellerID)
		{
			$sql = 'SELECT * FROM `bookCopy` WHERE sellerID=:sellerID;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':sellerID', $sellerID);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* get all info from bookCopy based on copyID*/
		function getCopyInfo($copyID)
		{
			//sql SELECT statement
			$sql = 'SELECT * FROM bookCopy WHERE copyID=:copyID;';
			
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':copyID', $copyID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* add request */
		function addRequest($userID, $bookID)
		{
			// build INSERT query string
			$sql = 'INSERT INTO `bookRequests` ( `userID` , `bookID`, `filled` ) VALUES ( :userID, :bookID, :filled);';
			$filled = 0;
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userID', $userID );
			$stmt->bindValue( ':bookID', $bookID );	
			$stmt->bindValue( ':filled', $filled );	
			$stmt->execute();
		}
		
		/*check if request has been filled and send them an email */
		function requestChecker($bookID, $bookTitle, $bookISBN, $bookAuthor)
		{
			$sql = 'SELECT userID, filled, requestID FROM `bookRequests` WHERE bookID=:bookID;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':bookID', $bookID);
			$statement->execute();
			$requestR = $statement->fetchall(PDO::FETCH_ASSOC);
			$subject = "Book Request Has Been Filled!";
			foreach( $requestR as $request):
			//echo "in foreach";
				if($request[filled] == 0)
{
					/*****User Info****/
					//sql SELECT statement
					$sql = 'SELECT firstName, email FROM User WHERE userId=:userId;';
					// submit database query
					$stmt = $this->dbconn->prepare( $sql );
					$stmt->bindValue( ':userId', $request[userID] );
					$stmt->execute();
					$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
					
					/****Copy Info***/
					$sql = 'SELECT copyID FROM bookCopy WHERE bookID=:bookID;';
					// submit database query
					$stmt = $this->dbconn->prepare( $sql );
					$stmt->bindValue( ':bookID', $bookID );
					$stmt->execute();
					$copyReturn = $stmt->fetch(PDO::FETCH_ASSOC);
					$copyID = $copyReturn[copyID];
					//print_r($copyReturn);
					$body = "Dear " . $userInfo[firstName] . ", \n\n Your book request of " . $bookTitle . " by: " . $bookAuthor . " ISBN: " . $bookISBN . " has been filled.  Click the link to see this item.  http://campusloops.com/updateRequest.php?id=" . $copyID . "\n\n Sincerely, \n\n \t The CampusLoops Team";
					$headers = 'From: bookExchange@campusloops.com';
					mail($userInfo[email], $subject, $body, $headers);
					//echo "email sent";
					
				}
			
			endforeach;
		}
		
		/* get book request a user has based on userID */
		function bookRequestCountProfile($userID)
		{
			$sql = "SELECT count(*) FROM bookRequests WHERE userID=" . $userID . " AND filled=0;";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			return($count[0]);
		}
		
		/* count amount of book requests a user has */
		function bookRequestCountID($bookID)
		{
			$sql = "SELECT count(*) FROM bookRequests WHERE bookID=" . $bookID . " AND filled=0;";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			return($count[0]);
		}
		
		/* select all info from book requests based on userID */
		function getBookRequests($userID)
		{
			$sql = 'SELECT * FROM `bookRequests` WHERE userID=:userID AND filled=0;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':userID', $userID);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* count amount of book copies that exists based on bookID */
		function bookCopyExist($bookID)
		{
			$sql = "SELECT count(*) FROM bookCopy WHERE bookID=" . $bookID . ";";

			$result = $this->dbconn->query( $sql );
			$count = $result->fetch(PDO::FETCH_NUM);
			
			if($count[0] == 0){
				return false;
			}else{
				return true;
			}
		}
		
		/* update book request to filled where based on userID and bookID */
		function updateRequest($userID, $bookID)
		{
			$sql = 'UPDATE bookRequests SET filled = 1 WHERE userID=:userID AND bookID=:bookID;'; 
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userID', $userID );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->execute();
		}
		
		/* check is ISBN is valid */
		function ISBNCheck($ISBN10)
		{
			if(strlen($ISBN10) != 10)
				return false;
		 
			$a = 0;
			for($i = 0; $i < 10; $i++){
				if ($ISBN10[$i] == "X" || $ISBN10[$i] == "x"){
					$a += 10*intval(10-$i);
				} else if (is_numeric($ISBN10[$i])) {//running the loop
					$a += intval($ISBN10[$i]) * intval(10-$i);
				} else {
					return false;
				}
			}
			return ($a % 11 == 0);
		
		}
		
		/* check to make sure price is numeric */
		function priceChecker($price)
		{
			if(is_numeric($price)){
				return true;
			}else{
				return false;
			}	
		}
		
		/* check to make sure edition is numeric */
		function editionChecker($edition)
		{
			if(is_numeric($edition)){
				return true;
			}else{
				return false;
			}	
		}
		
		/* check to make sure picture link is valid */
		function photoChecker($picture)
		{
			if(filter_var($picture, FILTER_VALIDATE_URL)){
				return true;
			}else{
				return false;
			}
		}
		
		/* condition check */
		function conditionChecker($condition)
		{
			if($condition == "Condition"){
				return false;
			}else{
				return true;
			}
		}
		
		/* uppercase title */
		function upperCaseTitle($title)
		{
			// Our array of 'small words' which shouldn't be capitalised if
			// they aren't the first word. Add your own words to taste.
			$smallwordsarray = array(
			'of','a','the','and','an','or','nor','but','is','if','then','else','when',
			'at','from','by','on','off','for','in','out','over','to','into','with'
			);

			// Split the string into separate words
			$words = explode(' ', $title);

			foreach ($words as $key => $word)
			{
				// If this word is the first, or it's not one of our small words, capitalise it
				// with ucwords().
				if ($key == 0 or !in_array($word, $smallwordsarray))
				$words[$key] = ucwords($word);
			}

			// Join the words back into a string
			$newtitle = implode(' ', $words);

			return $newtitle;
		}
		
		/* gets request ID based on userID and bookID */
		function getRequestID($userID, $bookID)
		{
			//sql SELECT statement
			$sql = 'SELECT requestID FROM bookRequests WHERE userID=:userID AND bookID=:bookID;';
			//echo " ID gotten";
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userID', $userID );
			$stmt->bindValue( ':bookID', $bookID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry[requestID]);
		
		}
		
		/* gets request info based on requestID */
		function getRequestInfo($requestID)
		{
			$sql = 'SELECT * FROM bookRequests WHERE requestID=:requestID;';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':requestID', $requestID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* gets userinfo based on userID */
		function getUserInfo($userID)
		{
			$sql = 'SELECT * FROM User WHERE userId=:userId;';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':userId', $userID );
			$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* get all subjects ordered alphabetically */
		function getAllSubjects()
		{
			$sql = 'SELECT * FROM `subjects` ORDER BY subject ASC';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->execute();			
			$entry = $stmt->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* add a subject */
		function addSubject($subject1)
		{
			$subject = ucfirst($subject1);
			// build INSERT query string 
			$sql = 'INSERT INTO `subjects` ( `subject` ) VALUES ( :subject );';
			// submit database query
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':subject', $subject );
			$stmt->execute();
		}
		
		/* get subjectID */
		function getSubjectID($subject)
		{
			$sql = 'SELECT * FROM `subjects`WHERE subject=:subject';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue( ':subject', $subject );
			$stmt->execute();			
			$entry = $stmt->fetchall(PDO::FETCH_ASSOC);
			return($entry[subjectID]);
		}
		
		/* delete request based on requestID */
		function deleteRequest($requestID)
		{
			$sql = 'DELETE FROM `bookRequests` WHERE requestID=:requestID;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':requestID', $requestID);
			$statement->execute();
		}
	   
		/* delete copy based on copyID */
		function deleteBookCopy($copyID)
		{
			$sql = 'DELETE FROM `bookCopy` WHERE copyID=:copyID;';
			$statement = $this->dbconn->prepare( $sql );
			$statement->bindValue(':copyID', $copyID);
			$statement->execute();
		}
}

?>
