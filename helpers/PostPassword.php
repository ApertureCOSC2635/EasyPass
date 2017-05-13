<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

   use Helpers\Passwords;

   class PostPassword {

      protected $name;
      protected $username;
      protected $password;
      protected $notes;

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->name = $_POST['name'];
         $this->username = $_POST['username'];
         $this->password = $_POST['password'];
         $this->notes = $_POST['notes'];
      }

      public function newPassword() {
         $p = new Passwords;
         $data = (object) array(
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'notes' => $this->notes,
         );
         $p->create($data, $_SESSION['login']);
         header('Location: /');
      }

   }

   session_start();
   $post = new PostPassword;
   $post->newPassword();

?>
