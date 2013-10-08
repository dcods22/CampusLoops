<?php
	
	if($currentUser[activated] == 0){
		//echo "User Not Active";
		header('Location: http://campusloops.com/validate.php?error=1');	
	}
	
	if($_SESSION['schoolID'] != $currentUser[schoolID]){
		header('Location: http://campusloops.com/scripts/php/lib_logout.php');	
	}
?>

<!DOCTYPE HTML>
<html class = "container">
	
	<?php include "header/head.php"; ?>

	<body>
	<a name='top'></a>

	<?php $loginactive = false; ?>
		
	<?php 

		include "header/lib_nav.php"; 

		include "header/headerdiv.php";	

		include "header/nav.php";
	?>

	<div class="mainholder">
	
	<?php

		include "header/formsubjects.php";


	?>	
		
	<?php /*
		if(!(isset($_SESSION['username']))) {
			header('Location: index.php');
		}
	*/?>
	
	<?php
		include('scripts/php/chatGet.php');
	?>
	
		<div class="bodyHolder">
			<div class="bodyFont">