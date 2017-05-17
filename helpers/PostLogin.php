<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
   include_once($_SERVER['DOCUMENT_ROOT'].'/helpers/TelstraSMS.php');

   use TelstraSMS;
   use Helpers\Login;

   class PostLogin {

      protected $email;
      protected $mobile;
      protected $CONSUMER_KEY="VvIuayZTnz0t78rbfZMqRhuilXSYR8x4";
      protected $CONSUMER_SECRET="xV269g1hCyfmzddq";

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->email = $_POST['email'];
         $this->mobile = $_POST['mobile'];
      }

      public function checkUser() {
         session_start();
         $emailRegexp = "/^[a-zA-Z0-9_.-]+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/";
         // Validate Email address
         if (preg_match($emailRegexp, $this->email) == false) {
             $_SESSION['error'] = "Invalid email address.".$this->CONSUMER_KEY;
             header('Location: /');
             return;
         }
         $mobileRegExp = "/^\({0,1}((0|\+61)(2|4|3|7|8)){0,1}\){0,1}(\ |-){0,1}[0-9]{2}(\ |-){0,1}[0-9]{2}(\ |-){0,1}[0-9]{1}(\ |-){0,1}[0-9]{3}$/";
         // Validate Date of Birth
         if (preg_match($mobileRegExp, $this->mobile) == false) {
             $_SESSION['error'] = "Invalid Mobile phone number.";
             header('Location: /');
             return;
         }
         // Hash the email and dob together to create a password.
         $magic = hash("sha256", $this->email.$this->mobile);
         // Create a new object of the login class
         $login = new Login;
         // Check if the user exists within the database. If the user exists the dob is then checked by comparing the $magic variable. If succesfull the login session is set. An error message is set otherwise.
         $result = $login->exists($this->email);
         if($result == true) {
            $result = $login->verify($magic, $this->email);
            if($result == true) {
               $_SESSION['login'] = $this->email;
               $_SESSION['sms'] = bin2hex(openssl_random_pseudo_bytes('4'));
               $message = "Your SMS code is ".$_SESSION['sms'];
               $sms = new TelstraSMS($this->CONSUMER_KEY, $this->CONSUMER_SECRET, $this->mobile, $message);
               $sms->send();
            }
            else if ($result == false) {
               $_SESSION['error'] = "Invalid login.";
            }
         }
         // If the user did not exist in the database a new one is created and the new session set.
         else if($result == false) {
            $login->create($magic, $this->email);
            $_SESSION['sms'] = bin2hex(openssl_random_pseudo_bytes('4'));
            $message = "Your SMS code is ".$_SESSION['sms'];
            $sms = new TelstraSMS($this->CONSUMER_KEY, $this->CONSUMER_SECRET, $this->mobile, $message);
            $sms->send();
            $_SESSION['new'] = $this->email;
         }
         // Return to the application
         header('Location: /');
      }

   }

   // Creates a new object of the PostLogin class and calls the checkuser function.
   $post = new PostLogin;
   $post->CheckUser();

 ?>
