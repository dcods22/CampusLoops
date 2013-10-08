<div class="header">

	<form method="POST" action="scripts/php/lib_logout.php">
		<input type="submit" value="Log Out" id="logout"/>
	</form>

	<a href="home.php"><div class = "webName">Campus Loops</div>
	<div class="schoolName">Marist College</div></a>

	<a href='profile.php?id=<?php echo($currentUser[userId]); ?>'><img alt='avatar' src='<?php echo($currentUser[avatar]); ?>' id="propic"></a>
	
</div><!--end of header div-->

