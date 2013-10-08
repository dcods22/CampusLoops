<!--Philip Siconolfi -->


<?php
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
if ($currentUser[userClass]==2):
?>



<form style='text-align:center;' action='scripts/php/lib_add_forumtopics.php' method='post'>
	
	Name:<input type='text' name='forumName' required='required'/><br /> 
	<input type='submit' name='submit' value='Add Forum Topic' />
</form>
   

<?php
else:
header("Location: http://campusloops.com/home.php");
endif;

	include("lib/template/footer.php");

?>