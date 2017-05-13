<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/easypass/autoload.php');

   use helpers\Login;

   class PostLogin {

      protected $email;
      protected $dob;

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->email = $_POST['email'];
         $this->dob = $_POST['dateOfBirth'];
      }

      public function checkUser() {
         session_start();
         // Hash the email and dob together to create a password.
         $magic = hash("sha256", $this->email.$this->dob);
         // Create a new object of the login class
         $login = new Login;
         // Check if the user exists within the database. If the user exists the dob is then checked by comparing the $magic variable. If succesfull the login session is set. An error message is set otherwise.
         $result = $login->exists($this->email);
         if($result == true) {
            $result = $login->verify($magic, $this->email);
            if($result == true) {
               $_SESSION['login'] = $this->email;
            }
            else if ($result == false) {
               $_SESSION['error'] = "Invalid login.";
            }
         }
         // If the user did not exist in the database a new one is created and the new session set.
         else if($result == false) {
            $login->create($magic, $this->email);
            $_SESSION['new'] = $this->email;
         }
         // Return to the application
         header('Location: /easypass');
      }

   }

   // Creates a new object of the PostLogin class and calls the checkuser function.
   $post = new PostLogin;
   $post->CheckUser();

 ?>
