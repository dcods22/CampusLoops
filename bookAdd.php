<?php

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');

	?>
		<p class='addDescTitle'>Add the information about your book below!</p>
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
		
		if(isset($_GET['condition'])){
			$condition = $_GET['condition'];
		}else{
			$condition = "Condition";
		}
		
		if(isset($_GET['price'])){
			$price = $_GET['price'];
		}else{
			$price = "Price";
		}
		
		if(isset($_GET['desc'])){
			$desc = $_GET['desc'];
		}else{
			$desc = "Description";
		}
		
		if(isset($_GET['subject'])){
			$subject = $_GET['subject'];
		}else{
			$subject = "Subject";
		}
		
		if(isset($_GET['other'])){
			$other = $_GET['other'];
		}else{
			$other = "Other";
		}
		
		switch ($_GET['error'])
		{
			case 1: $errmsg = 'Title is empty.'; break;
			case 2: $errmsg = 'Author is empty.'; break;
			case 3: $errmsg = 'ISBN is empty.'; break;
			case 4: $errmsg = 'Condition is empty.'; break;
			case 5: $errmsg = 'Price is empty.'; break;
			case 6: $errmsg = 'ISBN is not 10 Digits or is invalid.'; break;
			case 7: $errmsg = 'Price is not numeric or is invalid.'; break;
			case 8: $errmsg = 'Edition is not numeric.'; break;
			case 9: $errmsg = 'Picture is not a link to the photo.'; break;
			case 10: $errmsg = 'You must choose a condition.'; break;
			case 11: $errmsg = 'You must either pick a subject or write in another option'; break;
		}
		
		print '<p class="errmsg">' . $errmsg . '</p>';
	?>	
	
	<div class='formDesc'>
		<br/><br/><br/><br/><br/><br/>
		ISBN must be a ISBN-10
	</div>
	
		<form action='scripts/php/addBook.php' method='POST' class='bookAdd'>
			<label><span style='color:#C80000;'>* Required</span></label><br/><br/>
			<label for='addtitle'><span id='askterik'>*</span></label><input type='text' name='addtitle' id='addtitle' value='<?php echo $title; ?>' placeholder='Title'/><br/><br/>
			<label for='addauthor'><span id='askterik'>*</span></label><input type='text' name='addauthor' id='addauthor' value='<?php echo $author; ?>' placeholder='Author'/><br/><br/>
			<label for='addISBN'><span id='askterik'>*</span></label>	<input type='text' name='addISBN' id='addISBN' value='<?php echo $ISBN; ?>' placeholder='ISBN'/><br/><br/>
			<input type='text' name='addedition' id='addedition' value='<?php echo $edition; ?>' placeholder='Edition'/><br/><br/>
			<input type='text' name='addpicture' id='addpicture' value='<?php echo $picture; ?>' placeholder='Link To Picture'/><br/><br/>
			<label for='addcondition'><span id='askterik'>*</span></label><select name='addcondition' id='addcondition' placeholder='Condition'>
				<option>Condition</option>
				<option value='Unused'>Unused</option>
				<option value='Great'>Great</option>
				<option value='Good'>Good</option>
				<option value='Ok'>Ok</option>
				<option value='Bad'>Bad</option>
				<option value='Terrible'>Terrible</option>
				</select><br/><br/>
				<label for='addprice'><span id='askterik'>*</span></label><input type='text' name='addprice' id='addprice' value='<?php echo $price; ?>' placeholder='Price'/><br/><br/>
				<select name='addsubject' id='addsubject'>
					<option value='-1'>Subject</option>
					<option value='0'>None</option>
				<?php
					$bookHandler = new BookController('books');
					$subjects = $bookHandler->getAllSubjects();
					foreach($subjects as $subject) : 
				?>
					<option name='addsubject' id='addsubject' value='<?php echo $subject[subjectID];?>'><?php echo $subject[subject]; ?></option>
				<?php endforeach;?>
			</select>
			<input type='text' name='addother' id='addother' value='<?php echo $option; ?>' placeholder='Other'/><br/><br/> 
			<textarea name='adddesc' name='adddesc' cols='45' placeholder='Description'><?php echo $desc; ?></textarea><br/><br/>
			<input type='submit' value='Add Book'/>
		</form>
<?	
	else:
?>

<div class='formDesc'>
	<br/><br/><br/><br/><br/><br/>
	ISBN must be a ISBN-10

</div>
	
<form action='scripts/php/addBook.php' method='POST' class='bookAdd'>
	<label><span style='color:#C80000;'>* Required</span></label><br/><br/>
	<label for='addtitle'><span id='askterik'>*</span></label><input type='text' name='addtitle' id='addtitle' placeholder='Title'/><br/><br/>
	<label for='addauthor'><span id='askterik'>*</span></label><input type='text' name='addauthor' id='addauthor' placeholder='Author'/><br/><br/>
	<label for='addISBN'><span id='askterik'>*</span></label><input type='text' name='addISBN' id='addISBN' placeholder='ISBN'/><br/><br/>
	<input type='text' name='addedition' id='addedition' placeholder='Edition'/><br/><br/>
	<input type='text' name='addpicture' id='addpicture' placeholder='Link To Picture'/><br/><br/>
	<label for='addcondition'><span id='askterik'>*</span></label><select name='addcondition' id='addcondition' placeholder='Condition'>
	<option>Condition</option>
		<option value='Unused'>Unused</option>
		<option value='Great'>Great</option>
		<option value='Good'>Good</option>
		<option value='Ok'>Ok</option>
		<option value='Bad'>Bad</option>
		<option value='Terrible'>Terrible</option>
	</select><br/><br/>
	<label for='addprice'><span id='askterik'>*</span></label><input type='text' name='addprice' id='addprice' placeholder='Price'/><br/><br/>
	<select name='addsubject' id='addsubject'>
		<option value='-1'>Subject</option>
		<option value='0'>None</option>
		<?php
			$bookHandler = new BookController('books');
			$subjects = $bookHandler->getAllSubjects();
			foreach($subjects as $subject) : 
		?>
			<option value='<?php echo $subject[subjectID];?>'><?php echo $subject[subject]; ?></option>
		<?php endforeach;?>
	</select>
	<input type='text' name='addother' id='addother' placeholder='Other'/><br/><br/>
	<textarea name='adddesc' placeholder='Description' name='adddesc' cols='45'></textarea><br/><br/>
	<input type='submit' class='addBookButton' value='Add Book'/>
</form>


<?php
	endif;
	include("lib/template/footer.php");

?>