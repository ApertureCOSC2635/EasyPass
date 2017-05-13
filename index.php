<?php
	session_start();
	include_once(dirname(__FILE__).'/autoload.php');
	if(isset($_SESSION['new'])) {
		$_SESSION['page'] = 'views/questions/create.php';
	}
	else if(!isset($_SESSION['login'])){
		$_SESSION['page'] = 'views/session/login.php';
	}
	else if(isset($_SESSION['login'])) {
		$_SESSION['page'] = 'views/manager/passwords.php';
	}
	include 'views/layout/master.php';

 ?>
