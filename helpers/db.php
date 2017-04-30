<?php
   function dbConnect($db) {
      $host = "localhost";
      $user = "easybot";
      $password = "z7JwtdSQFKsP2W6gGhAlGM9X";
      $conn = mysqli_connect($host, $user, $password, $db, 3306);
      return $conn;
   }
?>
