<?php //code by Phil Picinic
	
	// get $_GET variables and check for valid data
	$page = $_GET['page'];
	if(!is_numeric($page)):
		header('Location: http://campusloops.com/error.php');
	else:
	
	// includes
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	
	
	// get all notification threads for the User in the Notifications table
	$notifFetcher = new NotificationController('Notifications');
	$notifs = $notifFetcher->getNotifications($currentUser[userId]);
	
	// places the thread ids in $ids array
	$ids = array();
	for($i = 0; $i < count($notifs); $i++)
	{
		$ids[$i] = $notifs[$i][threadId];
	}
	
	// count pages to navigate
	for($y = 0; $y < count($notifs); $y+= 25)
	{
			$pagea++;
	}
	
	// create a ThreadController Object and retreive threads
	$threadFetcher = new ThreadController('Thread');
	$threads = $threadFetcher->retrieveMultipleThreads($ids);
	
	//create a UserController Object
	$users = new UserController('User');

	?>
	<div>
		<h1>Notifications: <?php echo $notCount ; ?></h1>
		<?php // shows if there are no notifications
			
			if(count($threads) == 0)
				echo('You have no notifications');
			
			// for loop that show all the threads
			for($i = (($page - 1) * 25); ($i < (($page * 25) - 1)) && ($i < count($threads)); $i++): 
				$threadId = $threads[$i][threadId];
				$notifId = $notifFetcher->getNotifId($currentUser[userId], $threadId);
				$userPostId = $notifFetcher->getPostId($notifId);
				$latestPostId = $threads[$i][latestPostId];
				if($latestPostId > $userPostId)
					echo('New');
				else
					echo('Old');
			?>
		
			<a class='threads' href='thread.php?id=<?php echo($threads[$i][threadId]); ?>&amp;page=1'>
			<?php echo($threads[$i][threadName]); ?></a>
		 <br />
		<?php endfor; ?>
	<div style='text-align:center;'>
	<?php // create links to other pages in the specific thread
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
				echo("<a href='notifications.php?page=1'>First</a>|");
			if($page > 1){
				$previousPage = $page - 1;
				echo("<a href='notifications.php?page=$previousPage'>Previous</a>|");
			}
			for($i = $start; ($i <= $end) && ($i <= $pagea); $i++)
			{
				if($i == $pagea){
					$postCount = count($notifs);
					$startPost = ((($i - 1) * 25) + 1);
					echo("<a href='notifications.php?page=$pagea'>$startPost-$postCount</a>");
				}
				elseif($i == $end)
				{
					$startPost = ((($i - 1) * 25) + 1);
					$endPost = $end * 25;
					echo("<a href='notifications.php?page=$end'>$startPost-$endPost</a>");
				}
				
				else{
					$startPost = ((($i - 1) * 25) + 1);
					$endPost = $i * 25;
					echo("<a href='notifications.php?page=$i'>$startPost-$endPost</a>|");
				}
			}
			if($page < $pagea){
				$nextPage = $page + 1;
				echo("|<a href='notifications.php?page=$nextPage'>Next</a>");
			}
			if(($page + 1) < $pagea)
				echo("|<a href='notifications.php?page=$pagea'>Last</a>");
		}
	?>
	</div>
	</div>
	
	<?php
	include("lib/template/footer.php");
	
	endif;

?>