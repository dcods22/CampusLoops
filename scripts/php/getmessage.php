<?php

		$recID = $messageHandler->getRecIDInbox($messageID);
		$sendID = $messageHandler->getSendIDInbox($messageID);
		
		if($ID ==$sendID) {$senderID = $recID; $receiverID = $sendID;}
		if($ID == $recID) {$senderID = $sendID; $receiverID = $recID;}
		$mess = $messageHandler->getMessages($recID,$sendID);
		$formSendEmail = $messageHandler->getUserEmail($senderID);
		$prevID = "";
		$preMonth = "";
		$preday = "";
		$preyear = "";
		$prehour = "";
		$preminute = "";
		$mornNite = "";
?>
<table class='chatTable'><thead>
				<tr>
					<th></th>
					<th></th>					
				</tr>
			</thead>
			<tbody>
			
			<?php
			
			$messageCount = $messageHandler->messageCount($senderID, $receiverID);
			
			foreach($mess as $message) :		
			$senderEmail = $messageHandler->getUserEmail($message[senderID]);
			$receiverEmail = $messageHandler->getUserEmail($message[receiverID]);
			$senderUserName = $messageHandler->getUserName($message[senderID]);
			$receiverUserName = $messageHandler->getUserName($message[receiverID]);
			$userAvatar = $messageHandler->getUserAvatar($message[senderID]);
			
			list($year,$monthNum,$rest) = explode("-", $message[messageTime]);
			list($dayTime, $timeLeft) = explode(" ", $rest);
			list($hourTime,$minute, $second) = explode(":", $timeLeft);

			if($monthNum == 01) {$month = "Janurary";}
			else if($monthNum == 02) {$month = "February";}
			else if($monthNum == 03) {$month = "March";}
			else if($monthNum == 04) {$month = "April";}
			else if($monthNum == 05) {$month = "May";}
			else if($monthNum == 06) {$month = "June";}
			else if($monthNum == 07) {$month = "July";}
			else if($monthNum == 08) {$month = "August";}
			else if($monthNum == 9) {$month = "September";}
			else if($monthNum == 10) {$month = "October";}
			else if($monthNum == 11) {$month = "November";}
			else {$month = "December";}
			
			if($hourTime > 12) {$hour = $hourTime - 12; $mornNite = ' pm';} else {$hour = $hourTime; $mornNite = ' am';}
			
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
			
			if($preMonth == $month && $preday == $day && $preyear == $year && $premornNite == $mornNite){
				$time = $hour . ':' . $minute . $mornNite;
			}else{
				$time = $month . ' ' . $day . ' '  . $year . ' at ' . $hour . ':' . $minute . $mornNite;
			}
			
			$preMonth = $month;
			$preday = $day;
			$preyear = $year;
			$prehour = $hour;
			$preminute = $minute;
			$premornNite = $mornNite;
			
			if($message[senderID] != $ID and $message[receiverID] != $ID){header("Location: http://campusloops.com/messages.php?m=0");}
			
			if($message[senderID] == $prevID):
			
			?>
			
			<tr>
				<td width="40%"><br/><div <?php if($message[senderID] == $ID){echo("class='senderTextAlone'");} else{echo("class='receiverTextAlone'");} ?>><span style="<?php if($message[senderID] == $ID){echo("float:left");} else{echo("float:right");} ?>"><?php echo(htmlspecialchars($message[messageText]));?></span></div></div></td>
				<td width="20%"><div class='sendTime'><div style='float:right;'><?php echo $time;?></div></td>
			</tr>
			
			<?php 
			
			else:
			?>
			
			<tr>
				<td width="40%"><a href='profile.php?id=<?php echo($message[senderID]);?>'><img <?php if($message[senderID] == $ID){echo("class='senderPic'");} else{echo("class='receiverPic'");} ?>src='<?php echo($userAvatar); ?>' alt="sender Avatar" height="50px" width="50px"></img>
				<div  <?php if($message[senderID] == $ID){echo("class='sender'");} else{echo("class='receiver'");} ?>><div <?php if($message[senderID] == $ID){echo("class='senderName'");} else{echo("class='receiverName'");} ?>><?php echo($senderUserName); ?></div></a><br/><div <?php if($message[senderID] == $ID){echo("class='senderText'");} else{echo("class='receiverText'");} ?>><div <?php if($message[senderID] == $ID){echo("class='senderTextWords'");} else{echo("class='receiverTextWords'");} ?>><span style="<?php if($message[senderID] == $ID){echo("float:left");} else{echo("float:right");} ?>"><?php echo(htmlspecialchars($message[messageText]));?></span></div></div></div></td>
				<td width="20%"><div class='sendTime'><div style='float:right;'><?php echo $time;?></div></div></td>
			</tr>
			
			<?php 
			endif;
			$prevID = $message[senderID];
			endforeach;
			
			?>
	
			</tbody>
			</table>