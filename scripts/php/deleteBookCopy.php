<?php

	include('bookModel.php');
	include('lib_check_login.php');
	include("lib_profile.php");
	include('lib_User_model.php');
	include('lib_getUser.php');
	include("lib/template/header.php");
	
	$bookHandler = new BookController('books');
	$copyID = $_POST['copyID'];
	
	$bookHandler->deleteBookCopy($copyID);
	
	header('Location: http://campusloops.com/bookExchange.php');
	
?>