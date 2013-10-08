<?php
	
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');

	if(isset($_GET['id'])){
		$ID = $_GET['id'];
	}else{
		header('Location: http://campusloops.com/bookExchange.php');
	}
	
	$bookHandler = new BookController('books'); 
	$bookInfo = $bookHandler->getBookInfo($ID);
	?><p class='bookViewTitle'><?php echo $bookInfo[bookTitle]; ?><br/><?php echo 'By: ' . $bookInfo[author]; if($bookInfo[edition] != 1) { echo ', Edition: ' . $bookInfo[edition]; }?></p><?php
	$bookCount = $bookHandler->bookSaleCountID($ID);
	
	if($bookCount == 0){
		?> <br/><?php 
		echo "No Books Being Sold";
	}
	else{
		?><p class='viewDesc'> Click on the copy of each book being sold to get a more detailed description </p>
		<?php $results = $bookHandler->getAllBooks($ID);
	?>
	<br/>
	<table class='viewTable'><thead>
				<tr>	
					<th>Seller</th>
					<th>Price</th>
					<th>Condition</th>
					<th>Date Posted</th>
				</tr>
			</thead><tbody>
			
	<?php
	
	foreach($results as $result) :
	$senderName = $bookHandler->getSenderName($result[sellerID]);
	
	?>		
			
				<tr>
					<td class='bookViewSeller'><a href='bookCopy.php?id=<?php echo $result[copyID]; ?>'><?php echo $senderName; ?></a></td>
					<td class='bookViewPrice'><a href='bookCopy.php?id=<?php echo $result[copyID]; ?>'><?php echo $result[price]; ?></a></td>
					<td class='bookViewCondition'><a href='bookCopy.php?id=<?php echo $result[copyID]; ?>'><?php echo $result[Condition]; ?></a></td>
					<td class='bookViewDatePosted'><a href='bookCopy.php?id=<?php echo $result[copyID]; ?>'><?php echo $result[datePosted]; ?></a></td>
				</tr>
		<?		
			endforeach;
		?>	
			
			</tbody></table>
<?php
	}
	include("lib/template/footer.php");

?>
