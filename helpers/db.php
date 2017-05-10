<?php
   function dbConnect() {
      $config = include('db.config.php');
      $db = $config->name;
      $host = $config->host;
      $user = $config->user;
      $password = $config->password;
      $conn = mysqli_connect($host, $user, $password, $db, 3306);
      return $conn;
   }
?>
