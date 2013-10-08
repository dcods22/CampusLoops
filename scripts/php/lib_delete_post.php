<?php //Rick Gutierrez 

	
	include('lib_Posts_model.php');
	include('lib_Thread_model.php');
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	
	$postId = $_POST['postId'];
	$threadId = $_POST['threadId'];
	$page = $_POST['page'];
	
	if(!is_numeric($postId)){
			header('Location: http://campusloops.com/error.php');
			
		}
	elseif(!is_numeric($threadId))
		{
			header('Location: http://campusloops.com/error.php');
			
		}
		
	elseif(!is_numeric($page))
		{
			header('Location: http://campusloops.com/error.php');
			
		}
	else{
			$postcontroller= new PostsController('Posts');
			$postcontroller->deletePost($postId);
			$id = $postcontroller->getLatestPostId($threadId);
			$threadUpdater = new ThreadController('Thread');
			$threadUpdater->addPost($id, $threadId);
			header("Location: http://campusloops.com/thread.php?id=$threadId&page=$page");
		}
		
		
	
	
	}
	else{
	
	header('Location: http://campusloops.com/error.php');
	}
	
	
    //$threadUpdater = new ThreadController('Thread'); //Phil S. ;)
	//$threadUpdater->deletePost($postId, $Id); 
	
	
?>