<!--CODE BY Philip Siconolfi--->

<?php 
	
	// includes
	include('lib_check_login.php');
	include('lib_User_model.php');
	include('lib_getUser.php');
	include('lib_Forum_model.php');
	
	
	//check for a server POST request
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		
		
		//get $_POST variables
		$forumName = $_POST['forumName'];
	
		
		//check for valid data
		if( (empty($forumName)) || ($currentUser[userClass] != 2)){
			header('Location: http://campusloops.com/error.php');
		}
		else
		{
		$forumName1 = new ForumController('Forum_Topics');
		if($forumName1->isforumNameAvailable($forumName)){
			$forumName1->insertForumTopicName($forumName);
			
			header("Location: http://campusloops.com/home.php");
			}
			
			else{
			header('Location: http://campusloops.com/error.php');
			}
		}
		
	}
	else
	{
		header('Location: http://campusloops.com/error.php');
	}
?>