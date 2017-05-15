<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

   use Helpers\Login;

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
         $emailRegexp = "/^[a-zA-Z0-9_.-]+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/";
         // Validate Email address
         if (preg_match($emailRegexp, $this->email) == false) {
             $_SESSION['error'] = "Invalid email address.";
             header('Location: /');
             return;
         }
         $dobRegExp = '#^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]|
         (?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2]|
         (?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^
         (?:29(\/|-|\.)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|
         (?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9]|
         (?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$#';
         // Validate Date of Birth
         if (preg_match($dobRegExp, $this->dob) == false) {
             $_SESSION['error'] = "Invalid date of birth.";
             header('Location: /');
             return;
         }
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
         header('Location: /');
      }

   }

   // Creates a new object of the PostLogin class and calls the checkuser function.
   $post = new PostLogin;
   $post->CheckUser();

 ?>