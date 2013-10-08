<?php //code by Phil Picinic

	//includes
	include('lib_check_login.php');
	include('lib_User_model.php');
	include('lib_Posts_model.php');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		//get $_POST variables
		$postId = $_POST['postId'];
		$page = $_POST['page'];
		$threadId = $_POST['threadId'];
		$postBlock = $_POST['editPost'];
		$isPostTrimmed = trim($postBlock);
		
		//check if $postId and $threadId are valid
		if(!is_numeric($postId)){
			header('Location: http://campusloops.com/error.php');
		}
		elseif(!is_numeric($threadId)){
			header('Location: http://campusloops.com/error.php');
		}
		elseif(empty($isPostTrimmed))
		{
			header("Location: http://campusloops.com/thread.php?id=$threadId&page=$page");
		}
		else
		{
			// edit the post
			$postEditor = new PostsController('Posts');
			$postEditor->editPost($postBlock, $postId);
			
			//redirect to thread page
			header("Location: http://campusloops.com/thread.php?id=$threadId&page=$page");
		}
	}
?>