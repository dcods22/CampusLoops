<?php

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include("scripts/php/search.php");

	$search1 = $_POST['search'];
	
	$search = '%' . $search1 . '%';
	
	$searchController = new SearchController('User');
	$bookISBN = $searchController->searchBookISBN($search);
	$bookAuthor = $searchController->searchBookAuthor($search);
	$bookTitle = $searchController->searchBookTitle($search);
	$users = $searchController->searchUser($search);
	
?>

<p>
	
	<h2>Search Results: <?php echo $search1; ?></h2>
	
	<form method='POST' action='search.php'>
		<input type='text' placeholder='Search' name='search' id='bookSearch'/>
		<input type='submit' name='searchButton' id='searchButton' />
	</form>

<?php
	if(!empty($search1)):
?>	

	<a href='#users'>Jump To Users</a>

	<h3>Books</h3>
	<a name='books'></a>
<?php
	
	if(empty($bookISBN) && empty($bookAuthor) && empty($bookTitle)):
		
		echo 'No books found';
		
	else:

	$bookStruct = array();
?>

	<table class='searchTableBooks' >
	<thead>
		<tr>
			<th class='searchPicCol'>Picture</th>
			<th class='searchTitleCol'>Title</th>
			<th class='searchAuthorCol'>Author</th>
		</tr>
	</thead>
	<tbody>
<?php 
	
	foreach($bookISBN as $book) :
	
	if(!in_array($book[bookID],$bookStruct)):
	
	array_push($bookStruct, $book[bookID]);
?>
	
	<tr>
		<td align='center'><img src='<?php echo $book[picture]; ?>' alt='Book Picture' height='96px' width='64px' style='text-align:center;'/></td>
		<td class='searchBookTitle'  align='center'><a href='bookView.php?id=<?php echo $book[bookID]; ?>'><span ><?php echo $book[bookTitle]; ?></span></a></td>
		<td align='center'><a href='bookView.php?id=<?php echo $book[bookID]; ?>'><span class='searchBookAuthor'><?php echo $book[author]; ?></span></a></td>
	</tr>

<?php
	endif;

	endforeach;
	
	foreach($bookAuthor as $book) :
	
	if(!in_array($book[bookID],$bookStruct)):
	
	array_push($bookStruct, $book[bookID]);
?>	

	<tr>
		<td align='center'><img src='<?php echo $book[picture]; ?>' alt='Book Picture' height='96px' width='64px'/></td>
		<td align='center'><a href='bookView.php?id=<?php echo $book[bookID]; ?>'><span class='searchBookTitle'><?php echo $book[bookTitle]; ?></span></a></td>
		<td align='center'><a href='bookView.php?id=<?php echo $book[bookID]; ?>'><span class='searchBookAuthor'><?php echo $book[author]; ?></span></a></td>
	</tr>
	
<?php	
	endif;

	endforeach;
	
	foreach($bookTitle as $book) :
	
	if(!in_array($book[bookID],$bookStruct)):
	
	array_push($bookStruct, $book[bookID]);
?>
	
	<tr>
		<td align='center'><img src='<?php echo $book[picture]; ?>' alt='Book Picture' height='96px' width='64px' style='text-align:center;'/></td>
		<td align='center'><a href='bookView.php?id=<?php echo $book[bookID]; ?>'><span class='searchBookTitle'><?php echo $book[bookTitle]; ?></span></a></td>
		<td align='center'><a href='bookView.php?id=<?php echo $book[bookID]; ?>'><span class='searchBookAuthor'><?php echo $book[author]; ?></span></a></td>
	</tr>

<?php	
	endif;
	
	endforeach;
?>

	</tbody>
	</table>
	 
<?php
	endif;
	
	list($firstName,$lastName) = explode(" ",$search1);
	$firstName = '%' . $firstName . '%';
	$lastName = '%' . $lastName . '%';
	
	$names = $searchController->searchFirstLast($firstName, $lastName);
	
	$userStruct = array();
?>
	<h3>Users</h3>
	<a name='users'>
<?php
	if(empty($users) && empty($names)) :
	
		echo 'No Users found';
	
	else:
	
	foreach($names as $user):
	
	if(!in_array($user[userId],$userStruct)):
	
	array_push($userStruct, $user[userId]);
?>	
	
	<a href='profile.php?id=<?php echo $user[userId]; ?>'><?php echo $user[firstName] . ' ' . $user[lastName]; ?></a><br/><br/>

<?php
	endif;
	endforeach;
	 
	foreach($users as $user):
	if(!in_array($user[userId],$userStruct)):
	
	array_push($userStruct, $user[userId]);
?>	
	
	<a href='profile.php?id=<?php echo $user[userId]; ?>'><?php echo $user[firstName] . ' ' . $user[lastName]; ?></a><br/><br/>

<?php
	endif;
	endforeach;
	
	endif;
?>

</p>


<?php
	else:
	?>
		<br/>
		Your Search was empty please enter a search above. 
		</p>
	<?php
	endif;
	
	include("lib/template/footer.php");

?>