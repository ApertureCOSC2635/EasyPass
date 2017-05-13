<?php
   namespace Helpers;

   class Login extends Base {

      protected $config;
      protected $database;

      // The constructor sets the config variable which reads the database config from a file.
      public function __construct() {
         $this->config = Base::config('db');
         $this->database = Base::dbConnect($this->config);
      }

      // Checks if the user exists. If the user exists and questions have been setup then true is returned. If the user does not exist then false is returned. If the user exists but has not completed question setup then NULL is returned and a session set so that the user is directed to the question page.
      public function exists($email) {
         $query = "SELECT * FROM user WHERE email = '$email'";
         $result = $this->database->query($query);
         if($result->num_rows != 0) {
            $row = $result->fetch_assoc();
            if($row['q1'] == NULL) {
               $_SESSION['new'] = $email;
               return NULL;
            }
            else {
               return true;
            }
         }
         else {
            return false;
         }
      }

      // Verifies the users email and dob with the hash in the database. If the stored value matches the users input then true is returned otherwise false is returned.
      public function verify($magic, $email) {
         $query = "SELECT * FROM user WHERE email = '$email'";
         $result = $this->database->query($query);
         $row = $result->fetch_assoc();
         if($row['password'] == $magic) {
            return true;
         }
         else {
            return false;
         }
      }

      // Creates a new user and stores it in the database. Only email and password are set on the user.
      public function create($magic, $email) {
         $query = "INSERT INTO user (email, password) VALUES ('$email','$magic')";
         $result = $this->database->query($query);
      }

   }

 ?>
