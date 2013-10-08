<?php //code by Phil Picinic

	//creates a random salt key
	function make_salt_key()
	{
		$str = '/.0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = strlen($str) - 1;
		$salt = '$6$rounds=5000$';
		for($i = 0; $i < 21; $i++){
			$salt .= $str[mt_rand(0, $num)];
		}
		$salt .= '$';
		return($salt);
	}
?>	