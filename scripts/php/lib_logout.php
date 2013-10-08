<?php //code by Phil Picinic
	
	
	
		// destroys the session
		session_unset();
		$_SESSION['loggedin'] = '';
		$_SESSION = array();
		session_destroy();
		$_SESSION['loggedin'] = '';
		
		// removes all cookies from the browser
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"]);
			
			if(isset($_COOKIE['remember_me'])){
				setcookie('remember_me', '',time() - 42000, '/', 'campusloops.com');
			}
		}
		
		// redirects to log in page
		header('Location: http://campusloops.com/index.php');
	

?>