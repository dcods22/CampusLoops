<?php
	$to = 'daniel.cody2@marist.edu';
	$subject = 'Campus Loops Contact';
	$email = $_POST['contactEmail'];
	$body = $_POST['contactEmailBody'];
	$headers = "From: noreply@campusloops.com \r\n";
	$message = "FROM: " . $email . "\r\n \r\n BODY: " . $body;
	
	mail($to, $subject, $message, $headers);
	header('Location: http://campusloops.com');
?>