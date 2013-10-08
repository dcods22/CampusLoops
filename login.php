<?php include('lib/hometemplate/header.php'); ?>
		
<?php include('lib/hometemplate/headend.php') ?>

<?php
   if (isset($_GET['error']))
   {
      $errmsg = '';
      switch ($_GET['error'])
      {
      case 1: $errmsg = 'Incorrect login credentials.  Please try again.'; break;
      case 2: $errmsg = 'Unknown login error.  Please try again.'; break;
      }
      print '<p class="errmsg">' . $errmsg . '</p>';
   }
?>

	<div class = "login4">

		<form method="post" action="scripts/php/lib_login.php" >
			
			<label class="email3"></label>
			<input type="text" id="email" name="loginEmail" placeholder="Username"/><br />
			
			<label class="password4"></label>
			<input type="password" id="password" name="loginPassword" placeholder="Password" /><br />
			<input type="submit" id="submit2" value="Login" /> 
	  		
		</form>

		<p class="or"> OR </p>
	
		<form method="post" action="register.php" >

			<input type="submit" id="submit3" onclick="register.php" value="Sign Up Now!"/>

		</form>

	</div><!--end of login4 div-->

<?php include('lib/hometemplate/footer.php'); ?>