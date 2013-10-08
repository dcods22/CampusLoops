<?php // code by Phil Picinic
	
	// includes
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/lib_Forum_model.php');
	include("scripts/php/lib_Subforum_model.php");
	
	// grab $_GET variables
	$id = $_GET['id'];
	$action = $_GET['action'];
	
	// get the forumname via $id
	$forumController = new ForumController('Forum_Topics');
	$forumName = $forumController->getForumTopicName($id);
	
	// fetch all the according subforums
	$database = new SubForumController('Forum');
	$subforums = $database->grabSubforums($id);	
	
	// instantiate a ThreadController object to fetch threads in forums_view.php
	$threadController = new ThreadController('Thread');
	
	// check if forum topic exists and $id is numeric or redirect to error page
	if(empty($forumName) || !is_numeric($id)):
		header('Location: http://campusloops.com/error.php');
	else:
		// switch on $action to choose the corresponding view
		switch($action):
			case 'edit':
				// check if user is a moderator and include correct view
				if($currentUser[userClass] == 2):
					?>
					
					<form style='text-align:center;' action='scripts/php/lib_add_subforum.php' method='POST'>
						<input type='hidden' name='forumId' value='<?php echo($id); ?>' />
						SubLoop Title: <input type='text' name='subforumName'/><br />
						Thread Title: <input type='text' name='threadName'/>
						<textarea rows='15' cols='80' name='postBlock'></textarea>
						<br />
						<input type='Submit' name='submit' value='Add Subforum' />
					</form>
					
					<?php
				else:
				?>
					<div>
					<h1><?php echo($forumName); ?></h1>
					
					<?php // check if user is a moderator
					if($currentUser[userClass] == 2) : ?>
					<a href='forums.php?id=<?php echo($id); ?>&amp;action=edit'>[New SubLoop]</a>
					<br/>
					<?php 
					endif;
					// foreach and a nested for loop to print Subforums and threads under each subforum
					foreach($subforums as $item) : ?>
						<a class='subforumlinks' href='subloop.php?id=<?php echo($item[subforumId]); ?>&amp;page=1'><?php echo($item[subforumName]); ?></a>
						<div style='margin-left:25px;'>
						<?php
						$threads = $threadController->retrieveThreads($item[subforumId]);
						for($i = 0; ($i < 10) && ($i < count($threads)); $i++): ?>
							<a href='thread.php?id=<?php echo($threads[$i][threadId]); ?>&amp;page=1'><?php echo($threads[$i][threadName]); ?></a>
							<br />
						<?php endfor; ?>
						</div>
						<br />	
					<?php endforeach; ?>
					</div>
					
				<?php
				endif;
				break;
			default:
				//include default view
				?>
					<div>
					<h1><?php echo($forumName); ?></h1>
					
					<?php // check if user is a moderator
					if($currentUser[userClass] == 2) : ?>
					<a href='forums.php?id=<?php echo($id); ?>&amp;action=edit'>[New SubLoop]</a>
					<br/>
					<?php 
					endif;
					// foreach and a nested for loop to print Subforums and threads under each subforum
					foreach($subforums as $item) : ?>
						<a class='subforumlinks' href='subloop.php?id=<?php echo($item[subforumId]); ?>&amp;page=1'><?php echo($item[subforumName]); ?></a>
						<div style='margin-left:25px;'>
						<?php
						$threads = $threadController->retrieveThreads($item[subforumId]);
						for($i = 0; ($i < 10) && ($i < count($threads)); $i++): ?>
							<a href='thread.php?id=<?php echo($threads[$i][threadId]); ?>&amp;page=1'><?php echo($threads[$i][threadName]); ?></a>
							<br />
						<?php endfor; ?>
						</div>
						<br />	
					<?php endforeach; ?>
				</div>
						
				<?php
			break;
		endswitch;

		include("lib/template/footer.php");
	endif;
?>