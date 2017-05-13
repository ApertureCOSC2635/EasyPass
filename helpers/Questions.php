<?php
   namespace Helpers;

   class Questions extends Base {

      protected $config;
      protected $database;

      // The constructor sets the config variable which reads the database config from a file.
      public function __construct() {
         $this->config = Base::config('db');
         $this->database = Base::dbConnect($this->config);
      }

      public function create($questions, $answers, $email) {
         $query = "UPDATE user SET q1 = '$questions[0]',q2 = '$questions[1]',q3 = '$questions[2]', q1a = '$answers[0]', q2a = '$answers[1]', q3a = '$answers[2]' WHERE email = '$email'";
         $result = $this->database->query($query);
      }

      public function verify($answers, $email) {
         $query = "SELECT q1a,q2a,q3a FROM user WHERE email = '$email'";
         $result = $this->database->query($query);
         $row = $result->fetch_assoc();
         if($row['q1a'] == $answers[0] && $row['q2a'] == $answers[1] && $row['q3a'] == $answers[2]) {
            return true;
         }
         else {
            return false;
         }
      }

      public function getQuestions($email) {
         $query = "SELECT q1, q2, q3 FROM user WHERE email = '$email'";
         $result = $this->database->query($query);
         $row = $result->fetch_assoc();
         return (object) array(
            'q1' => $row['q1'],
            'q2' => $row['q2'],
            'q3' => $row['q3'],
         );
      }
   }

 ?>
