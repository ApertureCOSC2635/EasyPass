<?php
   function dbConnect() {
      $config = include($_SERVER['DOCUMENT_ROOT'].'/easypass/db.config.php');
      $db = $config->name;
      $host = $config->host;
      $user = $config->user;
      $password = $config->password;
      $conn = mysqli_connect($host, $user, $password, $db, 3306);
      return $conn;
   }
?>
