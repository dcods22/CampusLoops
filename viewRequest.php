<?php
	
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');

	if(isset($_GET['id'])){
		$requestID = $_GET['id'];
	}else{
		header('Location: http://campusloops.com/bookExchange.php');
	}
	
	$bookHandler = new BookController('books'); 
	$requestInfo = $bookHandler->getRequestInfo($requestID);
	$bookInfo = $bookHandler->getBookInfo($requestInfo[bookID]);
	$requesterInfo = $bookHandler->getUserInfo($requestInfo[userID]);
?>
	<!-- Javascript to grow the textarea as user types -->
	<script type='text/javascript'>
	  $(function() {
		$('textarea').autogrow();
	  });
	</script>
	
	<?php
		if($requestInfo[userID] == $currentUser[userId]) :
	?>
		<form action='scripts/php/deleteRequest.php' method='POST' class='deleteRequestForm'>
			<input type='hidden' name='requestID' value='<?php echo $requestID; ?>'/>
			<input type='submit' value='Delete Request' class='deleteRequestButton'/>
		</form>
	<?php
		endif;
	?>
	
	<div class='reqInfo'>
		<img src='<?php echo $bookInfo[picture]; ?>' alt='bookPicture' class='reqPic'/>
		<?php if($bookInfo[edition] != 1){ echo $bookInfo[bookTitle] . ' Edition: ' . $bookInfo[edition]; } else { echo $bookInfo[bookTitle]; }?> <br/><br/>
		<?php echo 'By: ' . $bookInfo[author]; ?> <br/><br/>
		<?php echo 'ISBN: ' . $bookInfo[ISBN]; ?> <br/><br/>
		<?php echo 'Requested by: '; ?><a href='profile.php?id=<?php echo $requestInfo[userID]; ?>'><?php echo $requesterInfo[firstName] . ' ' . $requesterInfo[lastName]; ?></a><br/><br/>
	</div><!-- end of reqInfo div-->	
<?php	
	
	include("lib/template/footer.php");
	
?>