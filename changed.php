<?php include('lib/hometemplate/header.php'); ?>
		
<?php include('lib/hometemplate/headend.php') ?>

<?php

	$ID = $_GET['id'];

   if (isset($_GET['error']))
   {
      $errmsg = '';
      switch ($_GET['error'])
      {
		  case 1: $errmsg = 'Password is not strong enough.  Please try again.'; break;
		  case 2: $errmsg = 'Passwords do not match.  Please try again.'; break;
		  case 3: $errmsg = 'One or both of the password fields are empty.  Please try again.'; break;
      }
      print '<p class="errmsg">' . $errmsg . '</p>';
   }
   	
?>

<h2>Password Help:</h2>

<?php
	if (isset($_GET['success'])):
?>
	<p>
		Your password has been changed. <br/>
		Click the link below to return to the home page to login.<br/><br/>
		<a href='index.php'>Return To Home</a>
	</p>

<?php
	else:
?>
	<div class='formDesc'>
			
			Password must contain 6 characters and 1 number 
		
	</div>

	<form method='POST' action='scripts/php/changePassword.php'>
		<input type='hidden' name='userID' value='<?php echo $ID; ?>' />
		<input type='text' name='password1' class='passForm' placeholder='New Password'/><br/><br/>
		<input type='text' name='password2' class='passForm' placeholder='Re-Enter Password'/><br/><br/>
		<input type='submit' value='Submit' class='defaultButton' />
	</form>
<?php
	endif;
?>

<?php include('lib/hometemplate/footer.php'); ?>