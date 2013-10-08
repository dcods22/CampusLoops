<?php // code by Phil Picinic

	// includes
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	
	// create a ThreadController Object and retrieve 25 most recent threads
	$database = new ThreadController('Thread');
	$threads = $database->retrieveHomeThreads();
	
	// create a UserController Object for use in view
	$users = new UserController('User');
	?>
	
	<h1>Home</h1>
	<h2>Most Recent Threads</h2>

	<?php // for loop to print the most recent threads
		for($i = 0; $i < count($threads); $i++) : ?>
			<a class='threads' href='thread.php?id=<?php echo($threads[$i][threadId]); ?>&amp;page=1'>
				<?php echo(htmlspecialchars($threads[$i][threadName])); ?>
			</a>
			<br />
	<?php endfor;

	include("lib/template/footer.php");

?>