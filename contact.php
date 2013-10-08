<?php include('lib/hometemplate/header.php'); ?>
		
<?php include('lib/hometemplate/headend.php') ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script src="scripts/js/autogrow.js"></script>
<script type='text/javascript'>
  
  $(function() {
	$('textarea').autogrow();
  });
			  
</script>

<p>

	<h2>Contact us by filling out the form below</h2>
	
	<form method='POST' action='scripts/php/contact.php'>
		<input type='text' name='contactEmail' id='contactEmail' placeholder='Contact Email' /><br/><br/>
		<textarea name='contactEmailBody' id='contactEmailBody' placeholder='Message' rows='4' cols='50' ></textarea><br/><br/>
		<input type='submit' value='Send' class='contactSend'/>
	</form>

</p>

<?php include('lib/hometemplate/footer.php'); ?>