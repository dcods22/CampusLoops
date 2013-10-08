<?php

	include('bookModel.php');

	$userID = $_POST['userID'];
	$addtitle = $_POST['addtitle'];	
	$addauthor = $_POST['addauthor'];	
	$addISBN = $_POST['addISBN'];	
	$addedition = $_POST['addedition'];	
	$addpicture = $_POST['addpicture'];	

	$bookHandler = new BookController('books');
	
	if(!empty($addtitle)){
		$newTitle = $bookHandler->upperCaseTitle($addtitle);
		$title = $newTitle;
		//$title = $addtitle;
	}else{
		header('Location: http://campusloops.com/bookRequest.php?error=1&author=' . $addauthor . '&title=' . '&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice);
	}
	
	if(!empty($addauthor)){
		$author = $addauthor;
	}else{
		header('Location: http://campusloops.com/bookRequest.php?error=2&title=' . $addtitle . '&author=' .'&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice);
	}
	
	if(!empty($addISBN)){
		$ISBN = $addISBN;
	}else{
		header('Location: http://campusloops.com/bookRequest.php?error=3&title=' . $addtitle . '&ISBN=' . '&author=' . $addauthor  . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice);
	}
	
	if(!empty($addedition)){
		$edition = $addedition;
	}else{
		$edition = 1;
	}
	
	if(!empty($addpicture)){
		$picture = $addpicture;
	}else{
		$picture = "http://campusloops.com/images/logo.png";
	}


	if($bookHandler->bookExists($ISBN))
	{
		$bookID = $bookHandler->getBookID($ISBN);
		$bookCopyExists = $bookHandler->bookCopyExist($bookID);
		//check if book exists
		if($bookCopyExists)
		{
			$copyID = $bookHandler->getCopyID($bookID);
			header('Location: http://campusloops.com/bookCopy.php?id=' . $copyID);
		}
		else
		{
			$bookHandler->addRequest($userID, $bookID);
			header('Location: http://campusloops.com/bookExchange.php');
		}
	}
	else
	{	
		$bookHandler->addBook($title, $author, $ISBN, $picture, $edition);
		$bookHandler->addRequest($userID, $bookID);
		header('Location: http://campusloops.com/bookExchange.php');
	}
	
	
?>