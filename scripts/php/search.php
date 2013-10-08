<?php

	class SearchController
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
			//$search = '%' . $search . '%';
			$sql = 'SELECT bookID,ISBN,author,bookTitle,edition,picture FROM books WHERE ISBN LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* search for books by Author */
		function searchBookAuthor($search)
		{
			//$search = '%' . $search . '%';
			$sql = 'SELECT bookID,ISBN,author,bookTitle,edition,picture FROM books WHERE author LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		/* search for books by Title */
		function searchBookTitle($search)
		{
			//$search = '%' . $search . '%';
			$sql = 'SELECT bookID,ISBN,author,bookTitle,edition,picture FROM books WHERE bookTitle LIKE :search;';
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
		
		function searchUserFirst($search)
		{
			$sql = 'SELECT * FROM ' . $this->tablename  . ' WHERE firstName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		
		function searchUserLast($search)
		{
			$sql = 'SELECT * FROM ' . $this->tablename  . ' WHERE lastName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchUser($search)
		{
			$sql = 'SELECT * FROM ' . $this->tablename  . ' WHERE lastName LIKE :search OR firstName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
		
		function searchFirstLast($search1, $search2)
		{
			$sql = 'SELECT * FROM ' . $this->tablename  . ' WHERE lastName LIKE :search1 AND firstName LIKE :search;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':search', $search1);
			$statement->bindValue(':search1', $search2);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	}
	
	
?>

