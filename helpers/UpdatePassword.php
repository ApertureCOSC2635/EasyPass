<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

   use Helpers\Passwords;

   class UpdatePassword {

      protected $name;
      protected $username;
      protected $password;
      protected $notes;
      protected $id;

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->name = $_POST['name'];
         $this->username = $_POST['username'];
         $this->password = $_POST['password'];
         $this->notes = $_POST['notes'];
         $this->id = $_POST['update_id'];
      }

      public function update() {
         $p = new Passwords;
         $p->destroy($this->id ,$_SESSION['login']);
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
   $post = new UpdatePassword;
   $post->update();

?>
