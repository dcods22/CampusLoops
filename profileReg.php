	<div class='profileInfo'>
					<h1> <?php echo($userInfo[firstName] . ' '); echo($userInfo[lastName]); ?> </h1>

					<br />

					<img id='profileAvatar' alt='avatar' src='<?php echo($userInfo[avatar]); ?>' style='max-width:250px; max-height:250px;' /><br />
		
					Email: <a href='messages.php?m=2&amp;sendto=<?php echo($profileID); ?>'><?php echo($userInfo[email]); ?></a><br />
	<?php			
			
				if(isset($userInfo[birthDate]))
				{
					echo('Birth Date: ');
						$birthDate = new DateTime($userInfo[birthDate]);
						$printBirth = $birthDate->format('F j');
						echo($printBirth);
				}
			if(isset($userInfo[facebook]) || isset($userInfo[twitter]) || isset($userInfo[instagram]) || isset($userInfo[linkedIn]) || isset($userInfo[tumblr])) :
			?>
				<br />
		
				Social Media: <br />
			<?php
				endif;

				if(isset($userInfo[facebook]))
					echo("<a href='$userInfo[facebook]' target='_blank'><img alt='facebook' src='images/facebook.png' width='32' /></a>");
				if(isset($userInfo[twitter]))
					echo("<a href='$userInfo[twitter]' target='_blank'><img alt='twitter' src='images/twitter.png' /></a>");
				if(isset($userInfo[instagram]))
					echo("<a href='$userInfo[instagram]' target='_blank'><img alt='instagram' src='images/instagram.png' /></a>");
				if(isset($userInfo[linkedIn]))
					echo("<a href='$userInfo[linkedIn]' target='_blank'><img alt='linkedIn' src='images/linkedin.png' /></a>");
				if(isset($userInfo[tumblr]))
					echo("<a href='$userInfo[tublr]' target='_blank'><img alt='tumblr' src='images/tumblr.png' /></a>");
?>
	</div><!--end of profileInfo div-->
	
	<div class='profileExtras'>
		<br/>
		<h2>Books For Sale</h2>
		 
		 <?php
			
			include('scripts/php/bookModel.php');
			
			$bookHandler = new BookController('books'); 
			$booksS = $bookHandler->getBooksSold($profileID);
			$bookCount = $bookHandler->bookSaleCountProfile($profileID);
			$n = 0;
			if($bookCount == 0){
				echo "No Books Being Sold";
			}
			else{
			?>
			<table class='profileTables'><thead>
			<tr><th>Title</th>
				<th>Author</th>
				<th>Edition</th>
				<th>ISBN</th>
				<th>Price</th>
				<th>Condition</th></tr>
			</thead>
			<?php
				foreach($booksS as $booksSold):
					$bookInfo = $bookHandler->getBookInfo($booksSold[bookID]);
			?>
				<tr <?php if(($n % 2) == 0){ echo "class='even'";}else{ echo "class='odd'"; } ?> >
					<td class='sellTitle'><a href='bookCopy.php?id=<?php echo $booksSold[copyID]; ?>'><?php echo $bookInfo[bookTitle]; ?></a></td>
					<td class='sellAuthor'><a href='bookCopy.php?id=<?php echo $booksSold[copyID]; ?>'><?php echo $bookInfo[author]; ?></a></td>
					<td class='sellEdition'><a href='bookCopy.php?id=<?php echo $booksSold[copyID]; ?>'><?php echo $bookInfo[edition]; ?></a></td>
					<td class='sellISBN'><a href='bookCopy.php?id=<?php echo $booksSold[copyID]; ?>'><?php echo $bookInfo[ISBN]; ?></a></td>
					<td class='sellPrice'><a href='bookCopy.php?id=<?php echo $booksSold[copyID]; ?>'><?php echo '$' . $booksSold[price]; ?></a></td>
					<td class='sellCondition'><a href='bookCopy.php?id=<?php echo $booksSold[copyID]; ?>'><?php echo $booksSold[Condition]; ?></a></td>
				</tr>
			<?php
				$n++;
				endforeach;
				
			}
		 ?>
		 </table>
		<h2>Book Requests</h2>
		
		<?php
		
			$bookR = $bookHandler->getBookRequests($profileID);
			$bookCountR = $bookHandler->bookRequestCountProfile($profileID);
			$n = 0;
			if($bookCountR == 0){
				echo "No Books Requested";
			}
			else{
			?>
			<table class='profileTables'><thead>
			<tr><th>Title</th>
				<th>Author</th>
				<th>Edition</th>
				<th>ISBN</th></tr>
			</thead>
			<?php
				foreach($bookR as $bookRequests):
					$bookInfoR = $bookHandler->getBookInfo($bookRequests[bookID]);
					$bookRequestID = $bookHandler->getRequestID($profileID, $bookRequests[bookID]);
			?>
				<tr <?php if(($n % 2) == 0){ echo "class='even'";}else{ echo "class='odd'"; } ?> >
					<td class='reqTitle'><a href='viewRequest.php?id=<?php echo $bookRequestID; ?>'><?php echo $bookInfoR[bookTitle]; ?></a></td>
					<td class='reqAuthor'><a href='viewRequest.php?id=<?php echo $bookRequestID; ?>'><?php echo $bookInfoR[author]; ?></a></td>
					<td class='reqEdition'><a href='viewRequest.php?id=<?php echo $bookRequestID; ?>'><?php echo $bookInfoR[edition]; ?></a></td>
					<td class='reqISBN'><a href='viewRequest.php?id=<?php echo $bookRequestID; ?>'><?php echo $bookInfoR[ISBN]; ?></a></td>
				</tr>
			<?php
				$n++;
				endforeach;
				
			}
		?>
		</table>
	  
	</div> <!--end of profileExtras div-->