<?php //code by Phil Picinic
	session_save_path("/home/users/web/b2942/ipg.campusloops/sessions");
	session_start();
	// checks if the remember me cookie is set
	if(isset($_COOKIE['remember_me'])){
		session_id($_COOKIE['remember_me']);
		$timeLength = 86400 * 365;
		setcookie('remember_me', $_COOKIE['remember_me'], time()+$timeLength, '/', 'campusloops.com');
	}
	
	// starts the session
	
	//print_r($_SESSION);
	// redirects to log in page if not logged in
	if(!isset($_SESSION['loggedin'])){
		header('Location: http://campusloops.com/index.php');
	}
				
?>