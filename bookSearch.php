<?php
	
	$search1 = trim($_GET['bookSearch']);
	
	if(!empty($search1)){
		$search = $search1;
    }else{
		header('Location: http://campusloops.com/bookExchange.php');
		//echo "Empty Search";
	}
	
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');
	
	$bookHandler = new BookController('books');  
	$bookI = $bookHandler->searchBookISBN($search);
	$bookA = $bookHandler->searchBookAuthor($search);
	$bookT = $bookHandler->searchBookTitle($search);
	
	$subject1 = trim($_GET['subject']);
	
	if(!empty($subject1)){
		$subject = $subject1;
		$bookS = $bookHandler->searchBookSubject($subject);
	}
	
?>	

	<h2>Search Results for: <?php echo $search; ?></h2>
	<form action='bookSearch.php' method='GET' class='bookForm'>
		<input type='text' name='bookSearch' id='bookSearch' placeholder='Search'/>
		<input type='submit' value='Search' class='searchButton'/>
	</form>
	<br/>
	
	<table class='searchResTable'><thead>
	  <tr>
		<th>Picture</th>
		<th>Title</th>
		<th>Author</th>
		<th>Edition</th>
		<th>ISBN</th>
	  </tr>	
	</thead>
	<tbody>
<?	
	foreach($bookI as $bookSearch) : 
?>
	  <tr>
		<td class='searchPic'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><img src='<?php echo $bookSearch[picture]; ?>' alt='picture' class='searchPic'/></a> </td>
		<td class='searchTitle'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[bookTitle]; ?> </a></td>
		<td class='searchAuthor'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[author]; ?> </a></td>
		<td class='searchEdition'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[edition]; ?> </a></td>
		<td class='searchISBN'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[ISBN]; ?> </a></td>
	  </tr>
<?php
	endforeach; 
?>

<?	
	foreach($bookT as $bookSearch) : 
?>
	  <tr>
		<td class='searchPic'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><img src='<?php echo $bookSearch[picture]; ?>' alt='picture' class='searchPic'/></a> </td>
		<td class='searchTitle'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[bookTitle]; ?> </a></td>
		<td class='searchAuthor'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[author]; ?> </a></td>
		<td class='searchEdition'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[edition]; ?> </a></td>
		<td class='searchISBN'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[ISBN]; ?> </a></td>
	  </tr>
<?php
	endforeach; 
?>

<?	
	foreach($bookA as $bookSearch) : 
?>
	  <tr>
		<td class='searchPic'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><img src='<?php echo $bookSearch[picture]; ?>' alt='picture' class='searchPic'/></a> </td>
		<td class='searchTitle'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[bookTitle]; ?> </a></td>
		<td class='searchAuthor'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[author]; ?> </a></td>
		<td class='searchEdition'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[edition]; ?> </a></td>
		<td class='searchISBN'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookSearch[ISBN]; ?> </a></td>
	  </tr>
<?php
	endforeach; 
?>

<?	
	foreach($bookS as $bookSearch) : 
	$bookInfo = $bookHandler->getBookInfo($bookSearch[bookID]);
?>
	  <tr>
		<td class='searchPic'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><img src='<?php echo $bookInfo[picture]; ?>' alt='picture' class='searchPic'/></a> </td>
		<td class='searchTitle'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookInfo[bookTitle]; ?> </a></td>
		<td class='searchAuthor'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookInfo[author]; ?> </a></td>
		<td class='searchEdition'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookInfo[edition]; ?> </a></td>
		<td class='searchISBN'><a href='bookView.php?id=<?php echo $bookSearch[bookID] ?>'><?php echo $bookInfo[ISBN]; ?> </a></td>
	  </tr>
<?php
	endforeach; 
?>
	</tbody></table>
<?php	
	include("lib/template/footer.php");

?>