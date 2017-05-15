<?php
   namespace Helpers;

   class Passwords extends Base {

      protected $config;
      protected $database;
      protected $secret_key;

      // The constructor sets the config variable which reads the database config from a file.
      public function __construct() {
         $this->config = Base::config('db');
         $this->database = Base::dbConnect($this->config);
         $this->secret_key = hash('sha256' ,$_SESSION['password']);
      }

      public function create($fields, $email) {
         if($fields->username != "" ){
           $encrypt_username  = $this->encrypt($fields->username, $this->secret_key);
         }
         if($fields->password != "" ){
           $encrypt_password  = $this->encrypt($fields->password, $this->secret_key);
         }
         $query = "INSERT INTO password (name, username, password, notes, user) VALUES ('$fields->name', '$encrypt_username', '$encrypt_password', '$fields->notes', '$email')";
         $result = $this->database->query($query);
      }

      public function destroy($id, $email) {
         $query = "DELETE FROM password WHERE user = '$email' AND id = $id";
         if(!$result = $this->database->query($query)){
           die('There was an error running the query [' . $this->database->error . ']');
       }
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

      public function getPasswords($email) {
         $query = "SELECT * FROM password WHERE user = '$email'";
         $result = $this->database->query($query);
         while($row = $result->fetch_array())
         {
            $rows[] = $row;
         }
	 if(isset($rows)) {
         foreach($rows as $row) {
            $username = "";
            $password = "";
            if($row['username'] != ""){
                 $username  = $this->decrypt($row['username'], $this->secret_key);
            }
            if($row['password'] != ""){
                 $password  = $this->decrypt($row['password'], $this->secret_key);
            }
            $passwords[] = (object) array(
               'id' => $row['id'],
               'name' => $row['name'],
               'username' => $username,
               'password' => $password,
               	'notes' => $row['notes'],
            	);
         	}
         	return $passwords;
	 }
      }

   }

 ?>
