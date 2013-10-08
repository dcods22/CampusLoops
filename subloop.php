<?php //code by Phil Picinic
	
	//includes
	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/lib_Subforum_model.php');
	include('scripts/php/lib_Posts_model.php');
	
	
	// get $_GET variables
	$id = $_GET['id'];
	$page = $_GET['page'];
	$action = $_GET['action'];
	
	
?>

	<?php
		switch($action):
			case 'edit':
				// include view to edit
				?>
				
				<form style='text-align:center;' action='scripts/php/lib_add_thread.php' method='post'>
					<input type='hidden' name='subforumId' value='<?php echo($id); ?>'/>
					Name:<input type='text' name='title' required='required'/><br />
					Post:<textarea name='postBlock' rows='15' cols='80'></textarea><br/>
					<input type='submit' name='submit' value='Post Thread' />
				</form>
				
				<?php
				break;
			default:
				// create a ThreadController Object and fetch all the threads based on the id from $_GET
				$database = new ThreadController('Thread');
				$threads = $database->retrieveThreads($id);
				
				//calculate how many pages exist for the subforum Id
				$pagea = 0;
				for($y = 0; $y < count($threads); $y+= 25)
				{
					$pagea++;
				}
				
				// create a SubforumController Object to get the subforum's name
				$subforum = new SubforumController('Forum');
				$subforumName = $subforum->getSubforumName($id);
				
				// create a UserController Object for use in view
				$users = new UserController('User');
				
				//include view file
				?>
				
				<h1><?php 
				echo($subforumName); ?></h1>
				<a href='subforums.php?id=<?php echo($id); ?>&amp;action=edit'>[New Thread]</a>
				<div>
				
				<?php // for loop that prints all the threads in the subforum
				for($i = (($page - 1) * 25); ($i <= (($page * 25) - 1)) && ($i < count($threads)); $i++) : ?>
					<a class='threads' href='thread.php?id=<?php echo($threads[$i][threadId]); ?>&amp;page=1'>
						<?php echo(htmlspecialchars($threads[$i][threadName])); ?>
					</a>
					<br />
				<?php endfor;?>
				<br />
				<div style='text-align:center;'>
				<?php // create links to other pages in the specific subforum
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
							echo("<a href='subforums.php?id=$id&amp;page=1'>First</a>|");
						if($page > 1){
							$previousPage = $page - 1;
							echo("<a href='subforums.php?id=$id&amp;page=$previousPage'>Previous</a>|");
						}
						for($i = $start; ($i <= $end) && ($i <= $pagea); $i++)
						{
							if($i == $pagea){
								$postCount = count($threads);
								$startPost = ((($i - 1) * 25) + 1);
								echo("<a href='subforums.php?id=$id&amp;page=$pagea'>$startPost-$postCount</a>");
							}
							elseif($i == $end)
							{
								$startPost = ((($i - 1) * 25) + 1);
								$endPost = $end * 25;
								echo("<a href='subforums.php?id=$id&amp;page=$end'>$startPost-$endPost</a>");
							}
							
							else{
								$startPost = ((($i - 1) * 25) + 1);
								$endPost = $i * 25;
								echo("<a href='subforums.php?id=$id&amp;page=$i'>$startPost-$endPost</a>|");
							}
						}
						if($page < $pagea){
							$nextPage = $page + 1;
							echo("|<a href='subforums.php?id=$id&amp;page=$nextPage'>Next</a>");
						}
						if(($page + 1) < $pagea)
							echo("|<a href='subforums.php?id=$id&amp;page=$pagea'>Last</a>");
					}
				?>
				</div>
				</div>

				
				<?php
				break;
		endswitch;
	?>

<?php
	//include footer
	include("lib/template/footer.php");

?>