<?php

	function encryptString($string) {
		// PASSWORD_DEFAULT uses BCRYPT
		$hash = password_hash($string, PASSWORD_DEFAULT);
		return $hash;
	}
	
	function decryptString($string, $hash) {
		if(password_verify($string, $hash)) {
			$success = 1;
		}
		else {
			$success = 0;
		}
		return $success;
	}

?>