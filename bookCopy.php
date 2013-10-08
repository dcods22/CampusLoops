<?php
	
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');

	if(isset($_GET['id'])){
		$copyID = $_GET['id'];
	}else{
		header('Location: http://campusloops.com/bookExchange.php');
	}
	
	$bookHandler = new BookController('books');
	$copyInfo = $bookHandler->getCopyInfo($copyID);	
	$bookInfo = $bookHandler->getBookInfo($copyInfo[bookID]);
	$sellerInfo = $bookHandler->getUserInfo($copyInfo[sellerID]);
	
	?>
	
	<!-- Javascript to grow the textarea as user types -->
	<script type='text/javascript'>
	  $(function() {
		$('textarea').autogrow();
	  });
	</script>
	
	<p>
		<div class='copyHolder'>
		
			<?php
				if($copyInfo[sellerID] == $currentUser[userId]) :
			?>
				<form action='scripts/php/deleteBookCopy.php' method='POST' class='deleteRequestForm'>
					<input type='hidden' name='copyID' value='<?php echo $copyID; ?>'/>
					<input type='submit' value='Delete Copy' class='deleteRequestButton'/>
				</form>
			<?php
				endif;
			?>
		
			<div class='copyPic'>
				<img src='<?php echo $bookInfo[picture]; ?>' alt='bookPicture' class='copyPic'/>
			</div>
			
			<div class='copyInfo'>
				<?php if($bookInfo[edition] != 1){ echo $bookInfo[bookTitle] . ' Edition: ' . $bookInfo[edition]; } else { echo $bookInfo[bookTitle]; }?><br/><br/>
				<?php echo 'By: ' . $bookInfo[author]; ?> <br/><br/>
				<?php echo 'ISBN: ' . $bookInfo[ISBN]; ?> <br/><br/>
				<?php echo $copyInfo[Condition] . ' Condition'; ?> <br/><br/>
				<?php echo 'For Sale by '; ?><a href='profile.php?id=<?php echo $copyInfo[sellerID];?>'><?php echo $sellerInfo[firstName] . ' ' . $sellerInfo[lastName]; ?></a> <br/><br/>
				<?php echo 'Asking for $' . $copyInfo[price]; ?> 
				<br/><br/><br/>
			
				Description: <br/><br/>
				<?php echo $copyInfo[description]; ?>
			
			</div><!--end of copy info div-->	
		</div><!--end of copy holder div-->
			<h3 style='text-align:center'><em>Send them an offer</em></h3>
			<form class='offerForm' action='scripts/php/offer.php' method='post'>
				<input type='hidden' name='userID' value='<?php echo $currentUser[userId]; ?>' />
				<input type='hidden' name='copyID' value='<?php echo $copyID; ?>' />
				<input type='hidden' name='bookID' value='<?php echo $copyInfo[bookID]; ?>' />
				<input type='hidden' name='sellerID' value='<?php echo $copyInfo[sellerID]; ?>' />
				<label for='offerPrice' class='labelOfferPrice'>Price:</label><input type='text' name='offerPrice' id='offerPrice' placeholder='Offer Price'/><br/>
			<div class='offerWrap'>	<label for='offerMessage' class='labelOfferMessage'>Message:</label><textarea name='offerMessage' id='offerMessage' placeholder='Message'></textarea><br/>
				</div><input type='submit' value='Send Offer' class='button'/>
			</form>
			
	</p>	
	<?php
	
	include("lib/template/footer.php");

?>