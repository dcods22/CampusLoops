<?php //code by Phil Picinic

	//includes
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/lib_Posts_model.php');
	include('scripts/php/lib_post_parser.php');
	include('scripts/php/userClasses.php');
	
	//get thread id and page of thread from $_GET superglobal
	$id = $_GET['id'];
	$page = $_GET['page'];
	
	//check $_GET super globals to be numeric or redirect with an error to prevent SQL injection
	if(!is_numeric($id))
		header('Location: http://campusloops.com/error.php');
	elseif(!is_numeric($page))
		header('Location: http://campusloops.com/error.php');
	else{
		//retrieve all posts to $post array
		$postFetcher = new PostsController('Posts');
		$posts = $postFetcher->retrievePosts($id);
	
		//create an object to access User database
		$userFetcher = new UserController('User');
	
		//get Thread Name
		$threadFetcher = new ThreadController('Thread');
		$threadName = $threadFetcher->getName($id);
		
		//Update Notifications table if user is in it
		//print_r($currentUser[userId]); print_r($id);
		$notificationUpdater = new NotificationController('Notifications');
		if($notificationUpdater->hasUserPosted($currentUser[userId], $id)){
			$notifId = $notificationUpdater->getNotifId($currentUser[userId], $id);
			$latestPostId = $threadFetcher->getLatestPostId($id);
			$notificationUpdater->updateNotification($notifId, $latestPostId);
		}
			
		
		//make sure page is valid, else go to not found error page
		//this also gets the amount of page links at the bottom
		$pagea = 0;
		$pagec = $page;
		
		for($y = 0; $y < count($posts); $y+= 25)
		{
			$pagea++;
		}
		if($page > $pagea)
			header('Location: http://campusloops.com/error.php');
	
		// get page number if user posts
		$pageb = 0;
		for($x = 0; $x <= count($posts); $x+= 25)
		{
			$pageb++;
		}
		if(($pagec == $pagea) && ((count($posts) % 25) == 1))
			$pagec--;

	}

	?>
	
	
<h1 id="threadName"><?php echo($threadName[threadName]); ?></h1>
	
	<?php //for loop that prints all posts on the current page
	for($i = (($page - 1) * 25); (($i <= (($page * 25) - 1) ) && ($i < count($posts))); $i++): ?>
			<div id='posts<?php echo($posts[$i][postId]); ?>'>
			<table>
			<tr style="width:800;">
			<td colspan="2"	style="width:700;">
			<a href='profile.php?id=<?php echo($posts[$i][userId]); ?>'>
			<?php $userName = $userFetcher->getName($posts[$i][userId]);
			echo("$userName[firstName] $userName[lastName]"); ?></a>
			<a href='messages.php?m=2&amp;sendto=<?php echo($posts[$i][userId]); ?>'><img alt='message' class='mailImage' src='images/email.png'/></a>
			
			<?php 
				list($year,$monthNum,$rest) = explode("-", $posts[$i][postDate]);
				list($dayTime, $timeLeft) = explode(" ", $rest);
				list($hourTime,$minute, $second) = explode(":", $timeLeft);
				if($monthNum == 01) {$month = "Janurary";}
				if($monthNum == 02) {$month = "February";}
				if($monthNum == 03) {$month = "March";}
				if($monthNum == 04) {$month = "April";}
				if($monthNum == 05) {$month = "May";}
				if($monthNum == 06) {$month = "June";}
				if($monthNum == 07) {$month = "July";}
				if($monthNum == 08) {$month = "August";}
				if($monthNum == 9) {$month = "September";}
				if($monthNum == 10) {$month = "October";}
				if($monthNum == 11) {$month = "November";}
				if($monthNum == 12) {$month = "December";}
				
				if($hourTime > 12) {$hour = $hourTime- 12; $mornNite = ' pm';} else {$hour = $hourTime; $mornNite = ' am';}
				
				if ($hour == 01) {$hour = 1;}
				else if ($hour == 02) {$hour = 2;}
				else if ($hour == 03) {$hour = 3;}
				else if ($hour == 04) {$hour = 4;}
				else if ($hour == 05) {$hour = 5;}
				else if ($hour == 06) {$hour = 6;}
				else if ($hour == 07) {$hour = 7;}
				else if ($hour == 08) {$hour = 8;}
				else if ($hour == 09) {$hour = 9;}
				else{ $hour = $hour;}
				
				if ($dayTime == 01) {$day = 1;}
				else if ($dayTime == 02) {$day = 2;}
				else if ($dayTime == 03) {$day = 3;}
				else if ($dayTime == 04) {$day = 4;}
				else if ($dayTime == 05) {$day = 5;}
				else if ($dayTime == 06) {$day = 6;}
				else if ($dayTime == 07) {$day = 7;}
				else if ($dayTime == 08) {$day = 8;}
				else if ($dayTime == 09) {$day = 9;}
				else{ $day = $dayTime;}
				
				$datetime1 = strtotime($posts[$i][postDate]);
				$datetime2 = time();
				$interval = $datetime2 - $datetime1;
				echo strtotime($interval);
				
				$time = $month . ' ' . $day . ' '  . $year . ' at ' . $hour . ':' . $minute . $mornNite;
				
				echo $time;
				?>
			
			<?php //edit button if post was posted by user or user is moderator
				if(($currentUser[userId] == $posts[$i][userId]) || ($currentUser[userClass] == 2)){
					$postId = $posts[$i][postId];
					echo("<div class='shownew' id='linkedit$postId' ><button type='button' onclick='editPost($postId)' id='editButton'>Edit</button></div>");
					echo("<div class='hidenew' id='linkcancel$postId' ><button type='button' onclick='cancelEdit($postId)' id='editButton'>Cancel</button></div>");
				}
			?>
			
			<?php // delete button on posts for moderator
			if(($currentUser[userClass] == 2) && ($i != 0)) : ?>
				<form style ='display:inline;' action='scripts/php/lib_delete_post.php' method='POST'>
					<input type='hidden' name='threadId' value='<?php echo($id); ?>' />
					<input type='hidden' name='page' value='<?php echo($pagec); ?>' />
					<input type='hidden' name='postId' value='<?php echo($posts[$i][postId]); ?>' />
					<input type='submit' name='submit' value='Delete' id='editButton'/>
				</form>
			
			<?php endif; ?>
			</td>
			</tr>
			<tr>
			<td style="width:150px; vertical-align:top;"><a href='profile.php?id=<?php echo($posts[$i][userId]); ?>'><img alt='avatar' width='150' src='<?php echo($userName[avatar]); ?>' /></a></td>
			
			<td style="width:650px; vertical-align:top; horizontal-align:left; float:left;">
			<?php 
			echo("<div class='shownew' id='post$postId'>");
			echo(parse_post($posts[$i][postBlock])); 
			?>
			</div>
			
			<?php //edit form
			if(($currentUser[userId] == $posts[$i][userId]) || ($currentUser[userClass] == 2)) : ?>
					<div class='hidenew' id='editpost<?php echo($postId); ?>'>
						<form method='post' action='scripts/php/lib_edit_post.php'>
							<input type='hidden' name='page' value='<?php echo($page); ?>'/>
							<input type='hidden' name='postId' value='<?php echo($postId); ?>'/>
							<input type='hidden' name='threadId' value='<?php echo($id); ?>'/>
							<textarea name='editPost' cols='80' rows='15'><?php echo($posts[$i][postBlock]);?></textarea>
							<br/>
							<input type='submit' name='edit' value='Post' id='editButton'/>
						</form>
					</div>
			<?php endif; ?>
			<br />
			<br />
			<?php //print edit date if post has been edited
			if(!empty($posts[$i][editDate])){
				$editDate = new DateTime($posts[$i][editDate]);
				$editPrint = $editDate->format('n/j/Y');
				echo("Last edited on: $editPrint");
				}
			?></td></tr></table></div>
	<?php endfor; ?>
	<h2>Post Reply</h2>
	
	<div id='postReply' style='text-align:center;'>
	<form method='post' action='scripts/php/lib_add_posts.php'>
	<input type='hidden' name='id' value='<?php echo($id); ?>' />
	<input type='hidden' name='page' value='<?php echo($pageb); ?>' />
	<textarea name='inputPost' id='inputPost' rows='3' cols='80'></textarea><br />
	
	<!-- Javascript to grow the textarea as user types -->
	<script type='text/javascript'>
	  $(function() {
		$('textarea').autogrow();
	  });
	</script>
	
	<input type='submit' name='Post Reply' value='Post Reply' class='postButton'/>
	</form>

	<br />
	<br />
	
	<?php // create links to other pages in the specific thread if thread contains more than 25 posts in it
		if($pagea > 1){
			$start = 1;
			if($pagea > 5){
				if($page == $pagea)
					$start = $page - 4;
				else if($page == ($pagea - 1))
					$start = $page - 3;
				else
					$start = $page - 2;
			}
			if($start < 1)
				$start = 1;
			$end = 5;
			if(($pagea > 5) && ($page > 3))
				$end = $page + 2;
			if($page > 2)
				echo("<a href='thread.php?id=$id&amp;page=1'>First</a>|");
			if($page > 1){
				$previousPage = $page - 1;
				echo("<a href='thread.php?id=$id&amp;page=$previousPage'>Previous</a>|");
			}
			for($i = $start; ($i <= $end) && ($i <= $pagea); $i++)
			{
				if($i == $pagea){
					$postCount = count($posts);
					$startPost = ((($i - 1) * 25) + 1);
					echo("<a href='thread.php?id=$id&amp;page=$pagea'>$startPost-$postCount</a>");
				}
				elseif($i == $end)
				{
					$startPost = ((($i - 1) * 25) + 1);
					$endPost = $end * 25;
					echo("<a href='thread.php?id=$id&amp;page=$end'>$startPost-$endPost</a>");
				}
				
				else{
					$startPost = ((($i - 1) * 25) + 1);
					$endPost = $i * 25;
					echo("<a href='thread.php?id=$id&amp;page=$i'>$startPost-$endPost</a>|");
				}
			}
			if($page < $pagea){
				$nextPage = $page + 1;
				echo("|<a href='thread.php?id=$id&amp;page=$nextPage'>Next</a>");
			}
			if(($page + 1) < $pagea)
				echo("|<a href='thread.php?id=$id&amp;page=$pagea'>Last</a>");
		}
	?>
	</div>
	
	<?php
	
	//include footer
	include("lib/template/footer.php");

?>