<?php
   namespace Helpers;

   class Logout {

      public function destroy() {
         session_start();
         session_unset();
         session_destroy();
         session_write_close();
         header('Location: /');
      }

   }

   Logout::Destroy();

 ?>
