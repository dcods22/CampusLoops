<?php

	include('bookModel.php');
	include('lib_check_login.php');
	include("lib_profile.php");
	include('lib_User_model.php');
	include('lib_getUser.php');
	include("lib/template/header.php");
	
	$bookHandler = new BookController('books');
		
	$addtitle = $_POST['addtitle'];	
	$addauthor = $_POST['addauthor'];	
	$addISBN = $_POST['addISBN'];	
	$addedition = $_POST['addedition'];	
	$addpicture = $_POST['addpicture'];	
	$addcondition = $_POST['addcondition'];
	$addprice = $_POST['addprice'];	
	$adddesc = $_POST['adddesc'];
	$addsubject = $_POST['addsubject'];
	$addother = $_POST['addother'];
	if(!empty($addtitle)){
		$newTitle = $bookHandler->upperCaseTitle($addtitle);
		$title = $newTitle;
		//$title = $addtitle;
	}else{
		header('Location: http://campusloops.com/bookAdd.php?error=1&author=' . $addauthor . '&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
	}
	
	if(!empty($addauthor)){
		$author = $addauthor;
	}else{
		header('Location: http://campusloops.com/bookAdd.php?error=2&title=' . $addtitle . '&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
	}
	
	if(!empty($addISBN)){
		$ISBN = $addISBN;
	}else{
		header('Location: http://campusloops.com/bookAdd.php?error=3&title=' . $addtitle . '&author=' . $addauthor  . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
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
	
	/*if(!empty($addcondition)){
		$condition = $addcondition;
	}else{
		header('Location: http://campusloops.com/bookAdd.php?error=4&title=' . $addtitle . '&author=' . $addauthor . '&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
	}*/
	
	if(!empty($addprice)){
		
		$dotExist = strpos($addprice, '.');

		if(!$dotExist){
			$addprice = $addprice . '.00';
		}
		
		list($dollars, $cents) = explode(".",$addprice);
		
		if(strlen($cents) > 2){
			$cents = substr($cents,0,2);
		}
		
		$price = $dollars . '.' . $cents;
		
	}else{
		header('Location: http://campusloops.com/bookAdd.php?error=5&title=' . $addtitle . '&author=' . $addauthor . '&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
	}
	
	if(empty($adddesc)){
		$desc = 'No Description Provided';
	}else{
		$desc = $adddesc;
	}
	
	if(empty($addother)){
		$subject = $addsubject;
		if($subject == "-1")
		{
			header('Location: http://campusloops.com/bookAdd.php?error=11&title=' . $addtitle . '&author=' . $addauthor . '&ISBN=' . $addISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&desc=' .$adddesc);
		}
	}else{
		$bookHandler->addSubject($addother);
		$subject = $bookHandler->getSubjectID($addother);
	}
	
	if($bookHandler->ISBNCheck($ISBN))
	{ 
		if($bookHandler->priceChecker($price))
		{
			//if($bookHandler->editionChecker($edition))
			//{
				if($bookHandler->photoChecker($picture))
				{
					if($bookHandler->conditionChecker($condition))
					{
						$datePosted = date("Y-m-d H:i:s");
						$sellerID = $currentUser[userId];
						$bookHandler->addBook($title, $author, $ISBN, $picture, $edition);
						$bookID = $bookHandler->getBookID($ISBN);
						$bookHandler->addBookCopy($bookID, $sellerID, $price, $condition, $datePosted, $desc, $subject);
						$bookHandler->requestChecker($bookID, $title, $ISBN, $author);
						header('Location: http://campusloops.com/bookExchange.php');
					}
					else
					{
						header('Location: http://campusloops.com/bookAdd.php?error=10&title=' . $addtitle . '&author=' . $addauthor  . '&ISBN=' . $ISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
					}
				}
				else 
				{
					header('Location: http://campusloops.com/bookAdd.php?error=9&title=' . $addtitle . '&author=' . $addauthor  . '&ISBN=' . $ISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
				}
			//}
			//else
			//{
			//	header('Location: http://campusloops.com/bookAdd.php?error=8&title=' . $addtitle . '&author=' . $addauthor  . '&ISBN=' . $ISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
			//}
		}
		else
		{
			header('Location: http://campusloops.com/bookAdd.php?error=7&title=' . $addtitle . '&author=' . $addauthor  . '&ISBN=' . $ISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
		}
	}
	else
	{
		header('Location: http://campusloops.com/bookAdd.php?error=6&title=' . $addtitle . '&author=' . $addauthor  . '&ISBN=' . $ISBN . '&edition=' . $addedition . '&picture=' . $addpicture . '&condition=' . $addcondition . '&price=' . $addprice . '&desc=' .$adddesc . '&subject=' . $addsubject . '&other=' . $addother);
	}
?>
