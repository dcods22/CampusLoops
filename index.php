<?php 
	include('scripts/php/lib_check_login_index.php');
 	include('lib/hometemplate/header.php');
	
	
 ?>
			<div class="login">
				<form action="scripts/php/lib_login.php" method="POST" class="login">
				<table>
					<tr>
					<td><label class="Username">Email:</label></td>
					<td><input type="text" id="email" name="loginEmail" placeholder="Email"/></td>
					</tr>
					
					<tr>	
					<td><label class="loginpass">Password:</label></td>
					<td><input type="password" id="password" name="loginPassword"  placeholder="Password"/></td>
					</tr>
				</table>	
					Remember Me: <input type="checkbox" id="remember" name="remember" value="yes" />
					<input type="submit" id="signin" value="Login" />

				</form>
			</div><!--end of login div-->

		<?php include('lib/hometemplate/headend.php') ?>

			 <p class="summary">
			 		Campus Loops is the way to get connected with your entire campus.  
					<br/><br/>People say Facebook is great, but it only connects you with your friends, when Campus Loops connects you with your entire campus.  
					<br/><br/>Want to know about a party or have a question about a teacher? Check the Loop.
					<br/><br/>Want to tell people about your event or a club? Make a loop. 
					<br/><br/>Have old books or need your new ones?  Sell and buy books through our book exchange.  
					<br/><br/>Get in the Loop on Campus Loops.

				</p>

				<form action="scripts/php/register.php" method="POST" class="signup">

					<label class="caccount">Create Your Account Here </label> <br/>
					<label class="caccount2">To connect with students on your campus</label><br/><br/>
					

					<label class="labelfirst"></label>
					<input type="text" id="firstname" name="firstname" placeholder="First Name"/>
					
					<label class="labellast"></label>
					<input type="text" id="lastname"  name="lastname" placeholder="Last Name"/>
					
					<br/>
					
					<label class="labelemail"></label>
					<input type="text" id="email1" name="email1" placeholder="Email Address"/>
					
					<br/>
					
					<label class="labelpassword1"></label>
					<input type="password" id="password1" name="password1" maxlength="23" placeholder="Password"/>
					
					<br/>
					
					<label class="labelpassword2"></label>
					<input type="password" id="password2" name="password2" placeholder="Re-Enter Password"/>
					
					<br/>

					<input type="submit" id="submit" value="Sign Up Now!"/><br/><br/>
					<label class='caccount2'>**Password must be 6 characters long with 1 number**</label><br/>
					<label class='caccount2'>**Must be a marist.edu email adress**</label><br/>
					<br/>
				</form>
				<!--
				<h2 class='schoolRegisterHead'>School not registered? Click below to add it</h2>
				<form method='POST' action='addSchool.php' class='indexAdd'>
					<input type='hidden' name='actionValue' value='add' />
					<input type='submit' value='Add School' class='addNewSubmit'>
				</form>
				-->

 		<?php include('lib/hometemplate/footer.php'); ?>