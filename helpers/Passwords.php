<?php
   namespace Helpers;

   class Passwords extends Base {

      protected $config;
      protected $database;

      // The constructor sets the config variable which reads the database config from a file.
      public function __construct() {
         $this->config = Base::config('db');
         $this->database = Base::dbConnect($this->config);
      }

      public function create($fields, $email) {
         $query = "INSERT INTO password (name, username, password, notes, user) VALUES ('$fields->name', '$fields->username', '$fields->password', '$fields->notes', '$email')";
         $result = $this->database->query($query);
      }

      public function getPasswords($email) {
         $query = "SELECT * FROM password WHERE user = '$email'";
         $result = $this->database->query($query);
         while($row = $result->fetch_array())
         {
            $rows[] = $row;
         }
         foreach($rows as $row) {
            $passwords[] = (object) array(
               'name' => $row['name'],
               'username' => $row['username'],
               'password' => $row['password'],
               'notes' => $row['notes'],
            );
         }
         return $passwords;
      }

   }

 ?>
