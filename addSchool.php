<?php include('lib/hometemplate/header.php'); ?>
		
<?php include('lib/hometemplate/headend.php') ?>

<?php	
	$action = $_POST['actionValue'];
	
	switch($action):
		case('add'): ?>
				<form action='scripts/php/addSchool.php' method='POST'>
					<input type='text' name='schoolName' placeholder='School Name' />
					<input type='text' name='schoolCity' placeholder='City' />
					<input type='text' name='schoolState' placeholder='State' />
					<input type='text' name='schoolEmail' placeholder='Email Signiture' />
					<input type='color' name='color1'/>
					<input type='color' name='color2'/>
					<input type='color' name='color3'/>
					<input type='submit' value='Submit'>
				</form>
			<?php break;
		default: ?>
			<p>
				Your school has been added, please go back to the home page and register<br />
				<a href='index.php' alt='home'>Return Home</a>
			</p>
	<?php endswitch;
?>

<?php include('lib/hometemplate/footer.php'); ?>