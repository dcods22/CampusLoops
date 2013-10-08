<?php //code by Dan Cody
	echo("
					
					<div classs='profupdate'>

					<p>
						<span class='profchange'><strong>Change your profiles information here:</strong></span>
					</p>

					<form method='POST' action='scripts/php/update.php' class='profupdate'>
						<label for='newfirstname' id='lnfirst'>First Name:</label>
						<input type='hidden' id='userID' name='userID' value='$profileID'/>
						<input type='hidden' id='userEmail' name='userEmail' value='$userInfo[email]'/>
						<input type='text' id='newfirstname' name='newfirstname' value='$userInfo[firstName]'/></br></br>

						<label for='newlastname' id='lnlast'>Last Name:</label>
						<input type='text' id='newlastname' name='newlastname' value='$userInfo[lastName]'/></br></br>

						<label for='newavatar' id='lnavatar'>Avatar:</label>
						<input type='text' id='newavatar' name='newavatar' value='$userInfo[avatar]'/></br></br>

						<label for='newmonth' id='lnbirthday'>Birthday:</label>
						<select name='newmonth' id=birthday>
					");
						$months = array();
						$months[1] = 'January';
						$months[2] = 'February';
						$months[3] = 'March';
						$months[4] = 'April';
						$months[5] = 'May';
						$months[6] = 'June';
						$months[7] = 'July';
						$months[8] = 'August';
						$months[9] = 'September';
						$months[10] = 'October';
						$months[11] = 'November';
						$months[12] = 'December';
						for($i = 1; $i <= 12; $i++) : ?>
						<option value='<?php echo($i); ?>' <?php if($userMonth == $i) echo("selected='selected'"); ?>><?php echo($months[$i]); ?></option>
						
						<?php endfor;
						
					echo("
						</select>

						<select name='newday'>
						");

						for($i=1;$i<=31;$i++)
						{
							if($userDay == $i){ echo("<option value=".$i." selected='selected'>".$i."</option>");}else{ echo("<option value=".$i.">".$i."</option>");}
						}
						echo("
						</select>

						<select name='newyear'>
						");
						for($i=1970;$i<=2013;$i++)
						{
						    if($userYear == $i){ echo("<option value=".$i." selected='selected'>".$i."</option>");}else{ echo("<option value=".$i.">".$i."</option>");}
						}
						echo("
						</select></br></br>

						<label for='newfacebook' id='lnfacebook'>Facebook:</label>
						<input type='text' id='newfacebook'name='newfacebook'  value='$userInfo[facebook]' /></br></br>

						<label for='newtwitter' id='lntwitter'>Twitter:</label>
						<input type='text' id='newtwitter'name='newtwitter'  value='$userInfo[twitter]' /></br></br>

						<label for='newinstagram' id='lninstagram'>Instagram:</label>
						<input type='text' id='newinstagram'name='newinstagram'  value='$userInfo[instagram]' /></br></br>

						<label for='newlinkedin' id='lnlinkedin'>LinkedIn:</label>
						<input type='text' id='newlinkedin'name='newlinkedin'  value='$userInfo[linkedIn]' /></br></br>

						<label for='newtumblr' id='lntumblr'>Tumblr:</label>
						<input type='text' id='newtumblr' name='newtumblr' value='$userInfo[tumblr]' /></br></br>

						<input type='submit' class='update' value='Update'/>
					</form>

					</div><!--end of profupdate div-->
				");		
?>