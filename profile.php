<?php //code by Dan Cody

	include('scripts/php/lib_check_login.php');
	include('scripts/php/lib_User_model.php');
	include('scripts/php/lib_getUser.php');
	include("lib/template/header.php");
	include("scripts/php/lib_profile.php");

	//create userController class to access database
	$userIdentify = new UserInfoController('User');
	
	//get user's email from session
	$email = $_SESSION['email'];

	$profileID = $_GET['id'];

	$edit = $_GET['edit'];

	//get user Id
	$user = $userIdentify->getUserInfo($email);
	
	$userID = $currentUser[userId];

	$userBirthday = $currentUser[birthDate];

	list($userYear,$userMonth,$userRest) = explode("-",$userBirthday);
	list($userDay, $rest) = explode(" ",$userRest);
	
?>
	
	<p>

		<?php

			if($userID==$profileID and $edit==0){
				echo("
					<form class='edit' action='http://campusloops.com/profile.php?id=$user[userId]&amp;edit=1' method='POST'>
						<input type='submit' value='Edit Profile' class='update'/>
					</form>
					");
			}


			if($edit==0){
				include("profileReg.php");
			}
			
			if($edit==1){
				if($userID === $profileID)
				{
					include("profileEdit.php");
				}
				else{
					header("Location: http://campusloops.com/profile.php?id=$profileID&amp;edit=0");
				}
			}
		?>
		

	

<?php

	include("lib/template/footer.php");

?>