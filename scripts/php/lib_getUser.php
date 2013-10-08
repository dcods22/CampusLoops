<?php //code by Phil Picinic
	
	// gets user's info based on session, should be globally included on all pages for use
	$email = $_SESSION['email'];
	$currentUserGrabber = new UserController('User');
	$currentUser = $currentUserGrabber->getUserInfo($email);
?>