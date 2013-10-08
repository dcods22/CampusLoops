<?php

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');
?>

	<p class='addDescTitle'>Add the information about your request below!</p>
 
<?php
 
	if(isset($_GET['error'])):
	
		$error = $_GET['error'];
		$errmsg = '';
		
		if(isset($_GET['title'])){
			$title = $_GET['title'];
		}else{
			$title = "Title";
		}
		
		if(isset($_GET['author'])){
			$author = $_GET['author'];
		}else{
			$author = "Author";
		}
		
		if(isset($_GET['ISBN'])){
			$ISBN = $_GET['ISBN'];
		}else{
			$ISBN = "ISBN";
		}
		
		if(isset($_GET['edition'])){
			$edition = $_GET['edition'];
		}else{
			$edition = "Edition";
		}
		
		if(isset($_GET['picture'])){
			$picture = $_GET['picture'];
		}else{
			$picture = "Picture";
		}
	
		switch ($_GET['error'])
		{
			case 1: $errmsg = 'Title is empty.'; break;
			case 2: $errmsg = 'Author is empty.'; break;
			case 3: $errmsg = 'ISBN is empty.'; break;
		}
		
		print '<p class="errmsg">' . $errmsg . '</p>';

?>	
	<div class='formDesc'>
		<br/><br/><br/><br/><br/><br/>
		ISBN must be a ISBN-10
	</div>	
	
	<form action='scripts/php/addBookRequest.php' method='POST' class='bookRequest'>
		<label><span style='color:#C80000;'>* Required</span></label><br/><br/>
		<input type='hidden' name='userID' id='userID' value='<?php echo $currentUser[userId]; ?>' />
		<label for='addtitle'><span id='askterik'>*</span></label><input type='text' name='addtitle' id='addtitle' placeholder='Title' value='<?php echo $title; ?>'/><br/><br/>
		<label for='addauthor'><span id='askterik'>*</span></label><input type='text' name='addauthor' id='addauthor' placeholder='Author' value='<?php echo $author; ?>'/><br/><br/>
		<label for='addISBN'><span id='askterik'>*</span></label><input type='text' name='addISBN' id='addISBN' placeholder='ISBN' value='<?php echo $ISBN; ?>'/><br/><br/>
		<input type='text' name='addedition' id='addedition' placeholder='Edition' value='<?php echo $edition; ?>'/><br/><br/>
		<input type='text' name='addpicture' id='addpicture' placeholder='Link To Picture' value='<?php echo $picture; ?>'/><br/><br/>
		<input type='submit' class='addBookButton' value='Add Request'/>
	</form>
	
<?php	
	else:
?>
	<div class='formDesc'>
		<br/><br/><br/><br/><br/><br/>
		ISBN must be a ISBN-10
	</div>	
	<form action='scripts/php/addBookRequest.php' method='POST' class='bookRequest'>
		<label><span style='color:#C80000;'>* Required</span></label><br/><br/>
		<input type='hidden' name='userID' id='userID' value='<?php echo $currentUser[userId]; ?>' />
		<label for='addtitle'><span id='askterik'>*</span></label><input type='text' name='addtitle' id='addtitle' placeholder='Title'/><br/><br/>
		<label for='addauthor'><span id='askterik'>*</span></label><input type='text' name='addauthor' id='addauthor' placeholder='Author'/><br/><br/>
		<label for='addISBN'><span id='askterik'>*</span></label><input type='text' name='addISBN' id='addISBN' placeholder='ISBN'/><br/><br/>
		<input type='text' name='addedition' id='addedition' placeholder='Edition'/><br/><br/>
		<input type='text' name='addpicture' id='addpicture' placeholder='Link To Picture'/><br/><br/>
		<input type='submit' class='addBookButton' value='Add Request'/>
	</form>


<?php
	
	endif;
	
	include("lib/template/footer.php");

?>