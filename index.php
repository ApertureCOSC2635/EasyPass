<?php
	session_start();
	include_once(dirname(__FILE__).'/vendor/autoload.php');
	if(isset($_SESSION['success'])) {
		$_SESSION['page'] = 'views/manager/passwords.php';
	}
	else if(isset($_SESSION['new'])) {
		$_SESSION['page'] = 'views/questions/create.php';
	}
	else if(isset($_SESSION['login'])) {
		$_SESSION['page'] = 'views/questions/verify.php';
	}
	else {
		$_SESSION['page'] = 'views/session/login.php';
	}
	include 'views/layout/master.php';

 ?>
