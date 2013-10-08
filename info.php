<?php include('lib/hometemplate/header.php'); ?>
		
<?php include('lib/hometemplate/headend.php') ?>

<?php
	$sent = $_GET['email'];
	
	if(isset($sent)):
	?>
	<p>
		An email has been sent.  Please check your email and click the link.
	</p>
<?php
	endif;
?>

<?php include('lib/hometemplate/footer.php'); ?>