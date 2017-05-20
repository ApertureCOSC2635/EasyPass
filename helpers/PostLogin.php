<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
   include_once($_SERVER['DOCUMENT_ROOT'].'/helpers/TelstraSMS.php');

   use TelstraSMS;
   use Helpers\Login;

   class PostLogin {

      protected $email;
      protected $mobile;
      protected $TELSTRA_KEY="VvIuayZTnz0t78rbfZMqRhuilXSYR8x4";
      protected $TELSTRA_SECRET="xV269g1hCyfmzddq";
      protected $RECAPCHA_PRIVATE_KEY="6LfHuCEUAAAAAPk4xweLFrkF9yUhTOkH61hbqv4I";

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->email = $_POST['email'];
         $this->mobile = $_POST['mobile'];
      }

      public function checkUser() {
         session_start();
         if (!$this->isRecapchaValid() != false) {
           $_SESSION['error'] = "The reCAPTCHA wasn't entered correctly. Go back and try it again. Are you a Robot?";
                header('Location: /');
                return;
         }
         $emailRegexp = "/^[a-zA-Z0-9_.-]+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/";
         // Validate Email address
         if (preg_match($emailRegexp, $this->email) == false) {
             $_SESSION['error'] = "Invalid email address.";
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
               $_SESSION['mobile'] = $this->mobile;
               $_SESSION['sms'] = bin2hex(openssl_random_pseudo_bytes('4'));
               $_SESSION['error'] = "";
               $message = "Your SMS code is ".$_SESSION['sms'];
               $sms = new TelstraSMS($this->TELSTRA_KEY, $this->TELSTRA_SECRET, $this->mobile, $message);
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
            $sms = new TelstraSMS($this->TELSTRA_KEY, $this->TELSTRA_SECRET, $this->mobile, $message);
            $sms->send();
            $_SESSION['new'] = $this->email;
            $_SESSION['mobile'] = $this->mobile;
            $_SESSION['error'] = "";
         }
         // Return to the application
         header('Location: /');
      }

      // This function is the original work of 'Levit' (June 10, 2015)
      // http://stackoverflow.com/users/1680919/levit
      // This code is used under the terms of the MIT licence.
      // https://opensource.org/licenses/MIT
      // Refer to Stackoverflow guidelines
      // https://meta.stackexchange.com/questions/271080/the-mit-license-clarity-on-using-code-on-stack-overflow-and-stack-exchange/271113#271113
      private function isRecapchaValid()
      {
          try {

              $url = 'https://www.google.com/recaptcha/api/siteverify';
              $data = ['secret'   => $this->RECAPCHA_PRIVATE_KEY,
                       'response' => $_POST['g-recaptcha-response'],
                       'remoteip' => $_SERVER['REMOTE_ADDR']];

              $options = [
                  'http' => [
                      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                      'method'  => 'POST',
                      'content' => http_build_query($data)
                  ]
              ];

              $context  = stream_context_create($options);
              $result = file_get_contents($url, false, $context);
              return json_decode($result)->success;
          }
          catch (Exception $e) {
              return null;
          }
      }

   }

   // Creates a new object of the PostLogin class and calls the checkuser function.
   $post = new PostLogin;
   $post->CheckUser();

 ?>
