<?php //Code by Dan Cody

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include('scripts/php/messageHandler.php');
	
	$page = $_GET['m'];
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script>

	function getUser()
	{
		var search = document.getElementById("receiver").value; 
		var xhr;  
		 if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		} 

		xhr.open("POST", "scripts/php/emailAJAX.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
		var data = "receiver=" + search;
		xhr.send(data);
		xhr.onreadystatechange = display_data;  
		
		function display_data() {  
		 if (xhr.readyState == 4) {  
		  if (xhr.status == 200) 
		  {  
			document.getElementById("suggestion").innerHTML = xhr.responseText; 	   
		  } else 
		    {  
				alert('There was a problem with the request.');  
		    }  
		 }  
		} 
	}
	
	function addText(text)
	{
		var add = text;
		//alert("entered");
		document.getElementById("receiver").value = add;
		var search = ''
		var xhr;  
		 if (window.XMLHttpRequest) { // Mozilla, Safari, ...  
			xhr = new XMLHttpRequest();  
		} else if (window.ActiveXObject) { // IE 8 and older  
			xhr = new ActiveXObject("Microsoft.XMLHTTP");  
		} 

		xhr.open("POST", "scripts/php/emailAJAX.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
		var data = "receiver=" + search;
		xhr.send(data);
		xhr.onreadystatechange = display_data;  
		
		function display_data() {  
		 if (xhr.readyState == 4) {  
		  if (xhr.status == 200) 
		  {  
			document.getElementById("suggestion").innerHTML = xhr.responseText; 	   
		  } else 
		    {  
				alert('There was a problem with the request.');  
		    }  
		 }  
		} 
	}
	  
	  
	  
</script>

<div class='messnav'>
	<ul class='messnav'>
		<li><a href='messages.php?m=0'>Inbox</a></li>
		<li><a href='messages.php?m=1'>Sent</a></li>
		<li><a href='messages.php?m=2'>New Message</a></li>
	</ul>
</div><!--end of messnav div-->

<br/><br/>

<?php

	$messageHandler = new MessageController('messages');

	if($page==0){
		
		echo("<h2 class='messLabel' >Inbox</h2>");
		$inboxHandler = $messageHandler->getInbox($ID);
		?>
		
		<p>
		<form action='scripts/php/deleteMessages.php' method='POST'>
		<input type='submit' class='deletemessage' value='Delete'/>
		<table class="messtable" id="messtable" border='1'>
		<thead><tr>
			<th><input type='checkbox' class='checkall' id='checkall'></th>
			<th>Sender</th>
			<th>Subject</th>
			<th>Time</th>
		</tr></thead>
		<tbody role="alert">
		
		<?php
		$i=0;
		foreach($inboxHandler as $inbox) : 
			$i++;
			list($year,$monthNum,$rest) = explode("-", $inbox[latestTime]);
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
			
			$userIDfromEmail = $messageHandler->getUserEmail($inbox[senderID]);
			?>

			<tr <?php if($i % 2 == 0){echo("class='odd'");} if($i % 2 == 1){echo("class='even'");} ?> >
				<td><input type='checkbox' name='delete' id='delete' value='<?php echo($inbox[inboxID]); ?>' class='delete' onclick="resetSelectAll();"/></td>
				<td><a href="chat.php?m=3&amp;id=<?php echo($inbox[inboxID]);?>"><?php echo($userIDfromEmail);?></a></td> 
				<td><a href="chat.php?m=3&amp;id=<?php echo($inbox[inboxID]);?>"><?php echo($inbox[subject]); ?></a></td>		
				<td><a href="chat.php?m=3&amp;id=<?php echo($inbox[inboxID]);?>"><?php echo $month . ' ' . $day . ' '  . $year . ' ' . $hour . ':' . $minute . $mornNite;;?></a></td>
			</tr>
			
		<?php endforeach;?>
		</tbody>
		</table>
		</form>
		
		<?php
		
	}
	
	elseif($page==1){
		echo("<h2 class='messLabel'>Sent</h2>");
		?>
		
		<p>
		<form action='scripts/php/deleteMessages.php' method='POST'>
		<input type='submit' class='deletemessage' value='Delete'/>
		<table class="messtable" id="messtable" border='1'>
		<thead><tr>
			<th><input type='checkbox' id='select_all'/></th>
			<th>Receiver</th>
			<th>Subject</th>
			<th>Time</th>
		</tr></thead>
		<tbody>
		<?php
		$i=0;
		$sentHandler = $messageHandler->getSent($ID);
		foreach($sentHandler as $sent) : 
			$i++;
			list($year,$monthNum,$rest) = explode("-", $sent[latestTime]);
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
			if($monthNum == 09) {$month = "September";}
			if($monthNum == 10) {$month = "October";}
			if($monthNum == 11) {$month = "November";}
			if($monthNum == 12) {$month = "December";}
			
			if($hourTime > 12) {$hour = 24 - $hourTime; $mornNite = ' pm';} else {$hour = $hourTime; $mornNite = ' am';}
			
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
			$userIDfromEmail = $messageHandler->getUserEmail($sent[receiverID])
		?>
			<tr <?php if($i % 2 == 0){echo("class='odd'");} if($i % 2 == 1){echo("class='even'");} ?> >
				<td><input type='checkbox' name='delete' id='delete' value='<?php echo($sent[inboxID]); ?>'/></td>
				<td><a href="chat.php?m=3&amp;id=<?php echo($sent[sentID]);?>"><?php echo($userIDfromEmail);?></a></td> 
				<td><a href="chat.php?m=3&amp;id=<?php echo($sent[sentID]);?>"><?php echo($sent[subject]); ?></a></td>		
				<td><a href="chat.php?m=3&amp;id=<?php echo($sent[sentID]);?>"><?php echo $month . ' ' . $day . ' '  . $year . ' ' . $hour . ':' . $minute . $mornNite;;?></a></td>
			</tr>
			
		<?php endforeach;?>
		</tbody>
		</table>
		</form>
		
		<?php
		
	}
	
	elseif($page==2){
	
		if(isset($_GET['sendto'])){
			$send = $_GET['sendto'];
			$sendto = $messageHandler->getUserEmail($send);
		}
		
		?>

			<form method='POST' action='scripts/php/sendmessage.php' class='newmessage'>
				<input type='hidden' name='senderemail' id='senderemail' value='$email'/>
			
			<?php
				if(isset($sendto)){ echo("<input type='text' onkeyup='getUser()' name='receiver' id='receiver' value='$sendto' /><br/><br/>");}
				else{ echo("<input type='text' onkeyup='getUser()' name='receiver' id='receiver' placeholder='To'/><br/><br/>");}
			?>
			<div id='suggestion'></div>
				<input type='text' name='subject' id='subject' placeholder='Subject'/><br/><br/>
				<textarea name='bodymessage' id='bodymessage' placeholder='Message' rows='3' ></textarea><br/><br/>
				<input type='submit' name='sendmessage' class='sendmessage' />
			</form>
			
			<script type='text/javascript'>
			  $(function() {
				$('textarea').autogrow();
			  });
			  
			</script>
	<?php 
	} 
	else{ //else for not page = 1 2 or 3
		header("Location: http://campusloops.com/messages.php?m=0");
	}
?>

<?php

	include("lib/template/footer.php");

?>