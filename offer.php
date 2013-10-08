<?php //code by Dan Cody

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/offerHandler.php');
	include('scripts/php/bookModel.php');
	
	$copyID = $_GET['copyID'];
	$sellerID = $_GET['sellerID'];
	$bookID = $_GET['bookID'];
	$buyerID = $currentUser[userId];
	
	$offerHandler = new OfferHandler('bookOffer');
	$bookHandler = new BookController('books');
	$copyInfo = $bookHandler->getCopyInfo($copyID);	
	$bookInfo = $bookHandler->getBookInfo($copyInfo[bookID]);
	$sellerInfo = $bookHandler->getUserInfo($sellerID);
	$userInfo = $bookHandler->getUserInfo($buyerID);
	$offers = $offerHandler->getAllOffers($sellerID, $buyerID, $bookID);
?>
	
	<h3>Offer for <?php echo $bookInfo[bookTitle] . ' Edition: ' . $bookInfo[edition]; ?></br> 
	Between 
	<a href='profile.php?id=<?php echo $sellerInfo[userId]; ?>'><?php echo $sellerInfo[firstName] . ' ' . $sellerInfo[lastName]; ?></a> and
	<a href='profile.php?id=<?php echo $userInfo[userId]; ?>'><?php echo $userInfo[firstName] . ' ' . $userInfo[lastName];?></a>
	</h3>
<?php
	$offerCount = 0;
	
	foreach($offers as $offer):

?>	
	Offer #<?php echo ++$offerCount; ?> was for $<?php echo $offer[price]; ?><br/><br/>
<?php
	endforeach;
?>	
<?php

	include("lib/template/footer.php");

?>