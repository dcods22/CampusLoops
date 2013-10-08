<?php

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/bookheader.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/bookModel.php');
	
	$bookHandler = new BookController('books');  
	$bookSubjects = $bookHandler->getAllSubjects();
?>
	<p>
<?
	foreach($bookSubjects as $bookSubject):
?>	

	<a href='bookSearch.php?bookSearch=<?php echo $bookSubject[subject]; ?>&subject=<?php echo $bookSubject[subjectID];?>' class='bookSubject'><?php echo $bookSubject[subject];?></a>

<?php
	endforeach;
?>
	</p>
<?php	
	
	include("lib/template/footer.php");

?>