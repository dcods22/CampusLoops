<?php

	class OfferHandler
	{
		private $dbconn;
		private $table;

		function __construct($tablename, $dbname = 'mars', $dblogin = 'sysadmin', $dbpass = 'test123', $url = 'campusloops.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}
	
		function getAllOffers($sellerID, $buyerID, $bookID)
		{
			$sql = 'SELECT * FROM bookOffer WHERE sellerID=:sellerID AND buyerID=:buyerID AND bookID=:bookID;';
			$statement = $this->dbconn->prepare($sql);
			$statement->bindValue(':sellerID', $sellerID);
			$statement->bindValue(':buyerID', $buyerID);
			$statement->bindValue(':bookID', $bookID);
			$statement->execute();
			$entry = $statement->fetchall(PDO::FETCH_ASSOC);
			return($entry);
		}
	
	}