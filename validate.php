 <?php include('lib/hometemplate/header.php'); ?>

 <?php include('lib/hometemplate/headend.php') ?>
 
 <?php
 
	$ID = $_GET['id'];
	
	if (isset($_GET['error']))
    {
      $errmsg = '';
      switch ($_GET['error'])
      {
      case 1: $errmsg = 'Please check your email and activate your account or resend the validation email below.'; break;
      case 2: $errmsg = 'Validation email has been sent.'; break;
      }
      print '<p class="errmsg">' . $errmsg . '</p>';
    }
 ?>
 
 	<div class='resend'>
		<p>Please Check your email for validation.
			<br/> Click below to resend validation Email<p>
		<form method='POST' action='scripts/php/sendValidationEmail.php' name='resend'>
			<input type='hidden' name='sendID' value='<?php echo $ID; ?>' />
			<input type='submit' value='Send' class='resendButton'/>
		</form>
	</div>

 
 <?php include('lib/hometemplate/footer.php'); ?>