<?php
	if(isset($_POST['hashString'])) {
		$edit_json = $_POST['hashString'];
		$array = json_decode($edit_json, true);
		foreach($array as $string) {
			$encrypted[] = encryptString($string);
		}
		return json_encode($encrypted);
	}
	
	if(isset($_POST['checkString'])) {
		
	}

?>