<?php //code by Phil Picinic
	
	
	session_save_path("/home/users/web/b2942/ipg.campusloops/sessions");
	
	//print_r($_COOKIE['remember_me']);
	// checks if remember me cookie is set
	if(isset($_COOKIE['remember_me'])){
		session_id($_COOKIE['remember_me']);
		//print_r($_COOKIE['remember_me']);
	}
	
	session_start();
	//print_r(session_id());
	// starts the session
	

	//print_r(isset($_SESSION['loggedin']));
	// if the user is logged in redirects to the home page
	if(isset($_SESSION['loggedin'])){
		//print_r("test<br/>debug");
		header("Location: http://campusloops.com/home.php");
		//print_r("test2");
	}
?>
	