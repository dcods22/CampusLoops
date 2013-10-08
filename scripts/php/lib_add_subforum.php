<?php //code by Phil Picinic

	//includes
	include('lib_check_login.php');
	include('lib_User_model.php');
	include('lib_getUser.php');
	include('lib_Subforum_model.php');
	include('lib_Thread_model.php');
	include('lib_Posts_model.php');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
		// get user's Id
		$userId = $currentUser[userId];
		
		// get POST variables
		$forumId = $_POST['forumId'];
		$subforumName = $_POST['subforumName'];
		$threadName = $_POST['threadName'];
		$postBlock = $_POST['postBlock'];
		
		//trim all neccessary variables
		$subforumName = trim($subforumName);
		$threadName = trim($threadName);
		$postTrimmed = trim($postBlock);
		
		//check the current user's class to be a moderator and data to be valid
		if(($currentUser[userClass] != 2) || (!is_numeric($forumId)) || (empty($subforumName)) || (empty($threadName)) || (empty($postTrimmed)) )
		{	
			header('Location: http://campusloops.com/error.php');
		}
		else
		{
			// create a SubForumController Object
			$subforumAdder = new SubForumController('Forum');
			
			// check if SubforumName is available
			if($subforumAdder->isSubforumNameAvailable($subforumName, $forumId) )
			{
				// Add the subforum
				$subforumAdder->addSubforum($forumId, $subforumName);
				
				//get the subforum ID
				$subforumId = $subforumAdder->getSubforumId($subforumName, $forumId);
				
				// add the first thread to the Subforum
				$threadAdder = new ThreadController('Thread');
				$threadAdder->addThread($subforumId, $threadName, $userId);
				$threadId = $threadAdder->getThreadId($subforumId, $threadName, $userId, 0, 1);
				
				// Add the first post to the above thread
				$postAdder = new PostsController('Posts');
				$postAdder->addPost($userId, $threadId, $postBlock);
				$postId = $postAdder->getLatestPostId($threadId);
			
				//Update the thread's lastest post ID
				$threadAdder->addPost($postId, $threadId);
						
				//redirect to the header page
				header("Location: http://campusloops.com/subforums.php?id=$subforumId&page=1");
			}
			else
			{
				header('Location: http://campusloops.com/error.php');
			}
		}
	}
	else
	{
		header('Location: http://campusloops.com/error.php');
	}
?>