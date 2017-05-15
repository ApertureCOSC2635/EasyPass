<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/phpcrypt/phpCrypt.php');
   use PHP_Crypt\PHP_Crypt as PHP_Crypt;
   class Passwords extends Base {

      protected $config;
      protected $database;
      protected $secret_key;

      // The constructor sets the config variable which reads the database config from a file.
      public function __construct() {
         $this->config = Base::config('db');
         $this->database = Base::dbConnect($this->config);
         $this->secret_key = $_SESSION['password'];
      }

      public function create($fields, $email) {
         $crypt = new PHP_Crypt($this->secret_key, PHP_Crypt::CIPHER_AES_128, PHP_Crypt::MODE_CBC, PHP_Crypt::PAD_PKCS7);
         $iv = $crypt->createIV();
         $encrypt_username = $crypt->encrypt($fields->username);
         $encrpyt_password = $crypt->encrypt($fields->password);
         $query = "INSERT INTO password (name, username, password, iv, notes, user) VALUES ('$fields->name', '$encrypt_username', '$encrpyt_password', '$iv', '$fields->notes', '$email')";
         $result = $this->database->query($query);
      }

      public function destroy($id, $email) {
         $query = "DELETE FROM password WHERE user = '$email' AND id = $id";
         if(!$result = $this->database->query($query)){
           die('There was an error running the query [' . $this->database->error . ']');
       }
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
            $crypt = new PHP_Crypt($this->secret_key, PHP_Crypt::CIPHER_AES_128, PHP_Crypt::MODE_CBC, PHP_Crypt::PAD_PKCS7);
            $crypt->IV($row['IV']);
            $username = $crypt->decrypt($row['username']);
            $password = $crypt->decrypt($row['password']);
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
