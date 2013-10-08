 <?php include('lib/hometemplate/header.php'); ?>

 <?php include('lib/hometemplate/headend.php') ?>

	<?php
	   if (isset($_GET['error']))
	   {
	      $errmsg = '';
	      switch ($_GET['error'])
	      {
	      case 1: $errmsg = 'A first name needs to be provided.'; break;
	      case 2: $errmsg = 'A last name needs to be provided'; break;
	      case 3: $errmsg = 'The email you have entered is invalid. Please try again.'; break;
	      case 4: $errmsg = 'The passwords you have entered do not match.  Please try again.'; break;
	      case 5: $errmsg = 'Username already exists in the database. Please choose a different username.'; break;
	      case 6: $errmsg = 'Error connecting or adding to the database.'; break;
		  case 7: $errmsg = 'Password is not strong enough it must contain atleast one number <br/> or special character and be atleast 6 characters long'; break;
	      default: $errmsg = 'An unknown error occurred. Please try again in a few minutes.'; break;
	      }
	      print '<p class="errmsg">' . $errmsg . '</p>';
	   }
	?>


       <div class = "register2">
       	
				<form action="scripts/php/register.php" method="POST" class="register">
					
					<label class="caccount3">Create Your Account Here </label> <br/>
					<label class="caccount4">To connect with students on your campus<br/></label>
					<label class='caccount2'>**Must be a .edu email adress**</label><br/>

					<!--<label for="firstname" class="lrfirstname"></label>-->
					<input type="text" id="firstname" name="firstname" class="rFirst" placeholder="First Name"/>

					<!--<label for="firstname" class="lrfirstname"></label>-->
					<input type="text" id="lastname" name="lastname" class="rLast" placeholder="Last Name"/>

					<br/>
					
					<label for="firstname" class="lrfirstname"></label>
					<input type="text" id="email1" name="email1" class="rEmail" placeholder="Email Address"/>
					
					<br/>

					<label for="password1" class="lrfirstname"></label>
					<input type="password" id="password1" name="password1" class="rPass1" placeholder="Password"/>
					
					<br/>
					
					<label for="password2" class="lrfirstname"></label>
					<input type="password" id="password2" name="password2" class="rPass2" placeholder="Re-Enter Password"/>
					
					<br/>
					
					<label for="firstname" class="lrfirstname"></label>
					<input type="submit" id="submit4" value="Sign Up Now!"/>
				  
				</form>

     </div><!--end div of regi<br/>-->

<?php include('lib/hometemplate/footer.php'); ?>