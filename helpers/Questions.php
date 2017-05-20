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
         $question1 = $this->encrypt($questions[0], $_SESSION['mobile']);
         $question2 = $this->encrypt($questions[1], $_SESSION['mobile']);
         $question3 = $this->encrypt($questions[2], $_SESSION['mobile']);

         $query = "UPDATE user SET q1 = '$question1',q2 = '$question2',q3 = '$question3', q1a = '$answers[0]', q2a = '$answers[1]', q3a = '$answers[2]' WHERE email = '$email'";
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
            'q1' => $this->decrypt($row['q1'], $_SESSION['mobile']),
            'q2' => $this->decrypt($row['q2'], $_SESSION['mobile']),
            'q3' => $this->decrypt($row['q3'], $_SESSION['mobile']),
         );
      }

      private function encrypt($data, $key){
         $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
         $encrypted = openssl_encrypt($data, 'aes-256-ctr', $key, 0, $iv);
         return base64_encode($encrypted . '::' . $iv);
      }


      private function decrypt($data, $key) {
      list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
      return openssl_decrypt($encrypted_data, 'aes-256-ctr', $key, 0, $iv);
      }
   }

 ?>
