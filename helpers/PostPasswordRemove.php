<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

   use Helpers\Passwords;

   class PostPasswordRemove {

      protected $id;

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->id = $_POST['password'];
      }

      public function removePassword() {
         $p = new Passwords;
         $p->destroy($this->id, $_SESSION['login']);
      }

   }

   session_start();
   $post = new PostPasswordRemove;
   $post->removePassword();

?>
