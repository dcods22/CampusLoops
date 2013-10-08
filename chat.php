<?php //Code by Dan Cody

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/messageHandler.php');
	
	$messageHandler = new MessageController('messages');
	
	if(isset($_GET['id'])){
			$messageID = $_GET['id'];
	}else{
		header("Location: http://campusloops.com/messages.php?m=0");
	}

?>

	<div class='messnav'>
		<ul class='messnav'>
			<li><a href='messages.php?m=0'>Inbox</a></li>
			<li><a href='messages.php?m=1'>Sent</a></li>
			<li><a href='messages.php?m=2'>New Message</a></li>
		</ul>
	</div><!--end of messnav div--><br/>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
	<script>
		/*
		var auto_refresh = setInterval(
		function()
		{
			$('#entireBody').load('chat.php');
		}, 2000);
		*/
	</script>
	
	<div id="chat">
		
		<?php 
			include('scripts/php/getmessage.php'); 
		?>
			
			
	</div><!--end of chat div-->
	
		
			<script type='text/javascript'>
			  
			  $(function() {
				$('textarea').autogrow();
			  });
			
			</script>
			
			<form id='chatmessage' method='POST' action='scripts/php/sendmessage2.php' style='text-align:center;'>
				<input type='hidden' name='receiver' value='<?php echo $formSendEmail; ?>'/>
				<input type='hidden' name='messageID' value='<?php echo $messageID; ?>' />
				<textarea name='bodymessage' class='sendTextArea' rows='3' cols='80' ></textarea><br/>
				<input type='submit' value='send' id='chatsubmit' class='sendMessageButton'/>
			</form>
<?php

	include("lib/template/footer.php");

?>