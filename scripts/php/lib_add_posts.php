<?php //code by Phil Picinic

	// includes
	include('lib_check_login.php');
	include('lib_User_model.php');
	include('lib_getUser.php');
	include('lib_Thread_model.php');
	include('lib_Posts_model.php');
	include('lib_Notifications_model.php');
	
	// check for POST request
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		// get POST variables
		$id = $_POST['id'];
		$page = $_POST['page'];
		$postBlock = $_POST['inputPost'];
		$isPostTrimmed = trim($postBlock);
		
		// check for valid data
		if(!is_numeric($id)){
			header('Location: http://campusloops.com/error.php');
		}
		elseif(!is_numeric($page))
		{
			header('Location: http://campusloops.com/error.php');
		}
		elseif(empty($isPostTrimmed))
		{
			header("Location: http://campusloops.com/thread.php?id=$id&page=$page");
		}
		else
		{
			// add the post to the Posts Table			
			$postAdder = new PostsController('Posts');
			$postAdder->addPost($currentUser[userId], $id, $postBlock);
			
			// get the latest postId from the thread that was posted in
			$postId = $postAdder->getLatestPostId($id);
			
			// update the thread with the latest postId for sorting threads elsewhere
			$threadUpdater = new ThreadController('Thread');
			$threadUpdater->addPost($postId, $id);
			
			// add the user to the notification table
			$notificationAdder = new NotificationController('Notifications');
			if($notificationAdder->hasUserPosted($currentUser[userId], $id))
			{
				$notifId = $notificationAdder->getNotifId($currentUser[userId], $id);
				$notificationAdder->updateNotification($notifId, $postId);
			}
			else{
				$notificationAdder->addToNotification($currentUser[userId], $id, $postId);
			}
			
			// redirect back to thread to the last page
			header("Location: http://campusloops.com/thread.php?id=$id&page=$page");
		}
	}
	else{
		header('Location: http://campusloops.com/error.php');
	}
?>