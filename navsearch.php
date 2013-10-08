<?php

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/lib_Thread_model.php');

	$action = $_POST['action'];
	
	switch($action):
		case 'search':
			if(isset($_POST['searchnav'])){
				$search = $_POST['searchnav'];
				$search = '%' . $search . '%';
			}
			else{
				header('Location: home.php');
			}
			
			$threadFetcher = new ThreadController('Thread');
			$postSearcher = new PostsController('Posts');
			$users = new UserController('User');
		?>
		
			<h2> Threads </h2>
		
		<?php 
		
			$threadResult = $threadFetcher->searchThreads($search);
			$threadResult = $threadFetcher->retrieveMultipleThreads($ids);
		?>
		<?php 
		
		if(!isset($results) || empty($results)): ?>
		<p>Your search found no results.</p>
	
		<?php
			
		break;
		default:
			echo("<p>You have not searched for anything yet.</p>");
			break;
	endswitch;
	
	
	include("lib/template/footer.php");
?>