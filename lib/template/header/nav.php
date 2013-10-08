<?php 
	
	//concate name to string and capitilize
	$fullName = ucfirst($currentUser[firstName]) . ' ' . ucfirst($currentUser[lastName]);

	include_once('scripts/php/lib_Thread_model.php');
	include_once('scripts/php/lib_Notifications_model.php');
	
	$notCountArray = array();
	
	$notifHandler = new NotificationController('Notifications');
	$threadFetcher = new ThreadController('Thread');
	$notifications = $notifHandler->getNotifications($currentUser[userId]);
	foreach($notifications as $notification):
		$userPostId = $notifHandler->getPostId($notification[notifId]);
		$latestPostId = $threadFetcher->getLatestPostId($notification[threadId]); 
		if($latestPostId > $userPostId)
			array_push($notCountArray, $notification[notifId]);
	endforeach;
	$notCount = sizeof($notCountArray);
		
?>

<div class="nav">
	<ul class="nav">
	  <li><a href='profile.php?id=<?php echo($currentUser[userId]); ?>'><strong><?php echo($fullName); ?></strong></a></li>
	  <li><a href='home.php?id=<?php echo($currentUser[userId]); ?>'><strong>Home</strong></a></li>
	  <li><a href="messages.php?m=0"><strong>Messages</strong></a></li>
	 <?php
		if($notCount == 0):?>
			<li><a href="notifications.php?page=1"><strong>Notifications</strong></a></li>
	<?php else:?>
			<li style='background-color:red;'><a href="notifications.php?page=1"><strong>Notifications (<?php echo $notCount; ?>)</strong></a></li>
	<?php endif; ?>
	  <li><a href="bookExchange.php"><strong>Book Exchange</strong></a></li>
	  <?php
	  
	  if ($currentUser[userClass]==2):
	  
	  ?>
	   <li><a href="addForumTopic.php"><strong>Add Forum Topic</strong></a></li>
	   
	  <?php
	  endif;
	  
	  ?>
	  
	  <li class="navsearch">
		<form method="POST" action="search.php">
			<input type='text' name='search' class='searchnav' id='searchnav' placeholder='Search...'/>
			<input type="submit" style="visibility: hidden;"/>
		</form>
	  </li>
	</ul>
</div><!--end of nav div-->