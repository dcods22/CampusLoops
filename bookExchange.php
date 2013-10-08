<?php

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');
	
?>

<p class='bookExchangeTitle'>Marist College Book Exchange</p>	
<p><em>Search by ISBN, Title, or Author</em></p>	
<form action='bookSearch.php' method='GET' class='bookForm'>
	<input type='text' name='bookSearch' id='bookSearch' placeholder='Search'/>
	<input type='submit' value='Search' class='searchButton'/>
</form>

<p class='exchangeInfo'>

Welcome to the Campus Loops Book Exchange!  Here you can add a book to sell, request a book, or see what books are available.  Why buy books from online websites when you can
support another student and get it in person, see what you are actually buying and be able to negotiate.  Add your books or make an offer on someone else's search for any book
above and if its not there hopefully you'll find it cheap somewhere else.    

</p>

<?php

	include("lib/template/footer.php");

?>