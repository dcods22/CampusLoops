<?php
	include('scripts/php/bookModel.php');
	
	$copyID = $_GET['id'];
	$bookHandler = new BookController('books');
	/****Copy Info***/
	$copyReturn = $bookHandler->getCopyInfo($copyID);
	/***Update filled***/
	$bookHandler->updateRequest($copyReturn[sellerID],$copyReturn[bookID]);
	header('Location: http://campusloops.com/bookCopy.php?id=' . $copyID);
?>