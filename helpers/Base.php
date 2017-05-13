<?php
   namespace Helpers;

   class Base {

      public function config($file) {
         $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'].'/';
         $config = include($ROOT_DIR.$file.'.config');
         return $config;
      }

      function dbConnect($config) {
         $db = $config->name;
         $host = $config->host;
         $user = $config->user;
         $password = $config->password;
         $conn = mysqli_connect($host, $user, $password, $db, 3306);
         return $conn;
      }

   }

 ?>
