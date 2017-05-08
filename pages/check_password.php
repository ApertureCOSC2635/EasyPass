<?php
   require_once ('../helpers/functions.php');
   $email = $_POST['email'];
   $magicNumber = $_POST['magic'];
   $password  = $_POST['hash'];

   $database = dbConnect();
   /* Update Database */
   if ($status = checkUserPassphrase($email, $magicNumber, $password, $database)){
     $ajaxdata['status'] = "passphrase_accepted";
     $ajaxdata['message'] = "Passphrase accepted.";
     $ajaxdata['html'] = displayUserPasswords();
   }
   else {
     $ajaxdata['status'] = "passphrase_failed";
     $ajaxdata['message'] = "Passphrase not accepted.";
   }
echo json_encode($ajaxdata);
?>
