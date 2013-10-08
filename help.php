<?php include('lib/hometemplate/header.php'); ?>
		
<?php include('lib/hometemplate/headend.php') ?>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="scripts/js/autogrow.js"></script>
<script type='text/javascript'>
  
    $(function() {
		$('textarea').autogrow();
    });
  
	$(function() {
		$( "#help" ).accordion({
			active:false,
			collapsible: true,
			heightStyle: "content",
			animate:true,
			
		});
    });
			
</script>

<h2>Check the tabs below for help:</h2>

<p>
	<div id='help'>
		<h3 class='helpSignUp'>Signed up with wrong email</h3>
			<div>If you signed up with the wrong email, contact help@campusloops.com with your name and correct email which a verification will be sent to.</div>
		<h3 class='helpForgot'>Forgot Password</h3>
			<div>
				Enter your email in the tab below to receive an email to change your password
				<form method='POST' action='scripts/php/sendForgotPassword.php'>
					<input type='text' name='email'  id='helpEmailForm' placeholder='Email'/>
					<input type='submit' value='Send' class='defaultButton'/>
				</form>
			</div>
		<h3 class='helpEdu'>No .edu email address</h3>
			<div>If you do not have a .edu email address please contact us at help@campusloops.com</div>
		<h3 class='helpEmail'>Did not get verification Email</h3>
			<div>
				Enter your email in the tab below to have a validation email resent to your email
				<form method='POST' action='scripts/php/resendVerification.php'>
					<input type='text' name='email' id='helpEmailForm' placeholder='Email'/>
					<input type='submit' value='Send' class='defaultButton'/>
				</form>
			</div>
		<h3>Privacy and Security</h3>
			<div>
			All information on this website is stored on a secure server and will not be used for anything besides the 
			basic intentions of this website.  All passwords and information will not be used to sell, contact or anything to any user.
			Any specific questions or concerns contact help@campusloops.com
			</div>
	</div>
</p>

<?php include('lib/hometemplate/footer.php'); ?>