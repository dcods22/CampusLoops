<?php //code by Phil Picinic

	// parser function that escapes html code and creates line breaks on a user's post
	function parse_post($str){
		$str = htmlspecialchars($str);
		$str = nl2br($str);
		return($str);
	}
?>