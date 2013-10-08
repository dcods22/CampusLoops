<?php //code by Phil Picinic
	
	// includes
	include('lib_check_login.php');
	include('lib_User_model.php');
	include('lib_getUser.php');
	include('lib_Thread_model.php');
	include('lib_Posts_model.php');
	include('lib_Notifications_model.php');
	
	//check for a server POST request
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$userId = $currentUser[userId];
		
		//get $_POST variables
		$subforumId = $_POST['subforumId'];
		$threadName = $_POST['title'];
		$postBlock = $_POST['postBlock'];
		$threadName = trim($threadName);
		$postTrimmed = $postBlock;
		
		//check for valid data
		if((!is_numeric($userId)) || (!is_numeric($subforumId)) || (empty($threadName)) || (empty($postTrimmed))) {
			header('Location: http://campusloops.com/error.php');
		}
		else
		{
			// add the thread and get the thread's id
			$threadAdder = new ThreadController('Thread');
			$threadAdder->addThread($subforumId, $threadName, $userId);
			$threadId = $threadAdder->getThreadId($subforumId, $threadName, $userId, 0, 1);
			
			// add thge post and get the post Id
			$postAdder = new PostsController('Posts');
			$postAdder->addPost($userId, $threadId, $postBlock);
			$postId = $postAdder->getLatestPostId($threadId);
			
			// update the thread's post Id
			$threadAdder->addPost($postId, $threadId);
			
			// add a notification for the user posting
			$notifAdder = new NotificationController('Notifications');
			$notifAdder->addToNotification($userId, $threadId, $postId);
			
			// redirect to the subforum
			header("Location: http://campusloops.com/subforums.php?id=$subforumId&page=1");
		}
	}
	else
	{
		header('Location: http://campusloops.com/error.php');
	}
?>